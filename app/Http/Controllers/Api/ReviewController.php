<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\ReviewContract;
use App\Events\BookingNotification;
use App\Http\Controllers\Controller;

use App\Http\Resources\ReviewCollection;

use App\Models\Booking;
use Illuminate\Http\Request;

use App\Services\Review\ReviewService;
use App\Services\Booking\BookingService;

use App\Events\ReviewCreated;

use App\Http\Resources\ReviewResource;
use App\Http\Requests\Review\ReviewCreateRequest;

use App\Jobs\TelegramReviewNotification;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    protected $paginate =   1;
    protected $reviewService;
    protected $bookingService;
    public function __construct(ReviewService $reviewService, BookingService $bookingService)
    {
        $this->reviewService    =   $reviewService;
        $this->bookingService   =   $bookingService;
    }

    /**
     * @throws ValidationException
     */
    public function create(ReviewCreateRequest $reviewCreateRequest)
    {
        $review     =   $this->reviewService->create($reviewCreateRequest->validated());
        $this->bookingService->update($review->{MainContract::BOOKING_ID},[
            MainContract::COMMENT    =>  MainContract::OFF
        ]);
        $booking    =   Booking::with('organization','organizationTables')->where(MainContract::ID,$review->{MainContract::BOOKING_ID})->first();
        event(new ReviewCreated($review));
        event(new BookingNotification($booking));
        TelegramReviewNotification::dispatch($review, $booking);
        return new ReviewResource($this->reviewService->getById($review->id));
    }

    public function update($id, Request $request)
    {
        $this->reviewService->update($id,$request->all());
        return new ReviewResource($this->reviewService->getById($id));
    }

    public function delete($id)
    {
        $this->reviewService->delete($id);
        $review =   $this->reviewService->getById($id);
        event(new ReviewCreated($review));
        return new ReviewResource($review);
    }

    public function getCountByOrganizationId($organizationId)
    {
        return $this->reviewService->getCountByOrganizationId($organizationId);
    }

    public function getByOrganizationId(int $id, $paginate): ReviewCollection
    {
        $this->paginate =   (int)$paginate;
        return new ReviewCollection($this->reviewService->getByOrganizationId($id,$this->paginate));
    }

    public function getByUserId(int $id, Request $request)
    {
        if ($request->has('paginate')) {
            $this->paginate =   (int)$request->input('paginate');
        }
        return new ReviewCollection($this->reviewService->getByUserId($id,$this->paginate));
    }

    public function getGroupByOrganizationId($organizationId)
    {
        return $this->reviewService->getGroupByOrganizationId($organizationId);
    }
}
