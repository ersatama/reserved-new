<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\PaymentContract;
use App\Domain\Contracts\UserContract;
use App\Http\Controllers\Controller;

use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\Booking\BookingCollection;

use App\Services\Booking\BookingService;
use App\Services\Payment\PaymentService;
use App\Services\User\UserService;
use App\Services\Organization\OrganizationService;

use App\Http\Requests\Booking\BookingCreateRequest;
use App\Http\Requests\Booking\BookingPaginateRequest;
use App\Http\Requests\Booking\BookingGuestRequest;
use App\Http\Requests\Booking\BookingUpdateRequest;
use App\Http\Requests\Booking\BookingPaymentCardRequest;
use App\Http\Requests\Booking\BookingIdsRequest;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    protected $bookingService;
    protected $paymentService;
    protected $userService;
    protected $organizationService;

    public function __construct(BookingService $bookingService, PaymentService $paymentService, UserService $userService, OrganizationService $organizationService)
    {
        $this->bookingService   =   $bookingService;
        $this->paymentService   =   $paymentService;
        $this->userService      =   $userService;
        $this->organizationService  =   $organizationService;
    }

    public function getCompletedByUserId($userId): BookingCollection
    {
        return new BookingCollection($this->bookingService->getCompletedByUserId($userId));
    }

    public function getByBetweenDateAndOrganizationId($start,$end,$organizationId): Collection
    {
        return $this->bookingService->getByBetweenDateAndOrganizationId($start,$end,$organizationId);
    }

    /**
     * @throws ValidationException
     */
    public function create(BookingCreateRequest $bookingCreateRequest):object
    {
        if ($booking    =   $this->bookingService->create($bookingCreateRequest->validated())) {
            if ($booking->{MainContract::PRICE} > 0) {
                $booking    =   $this->paymentService->create($booking);
            }
            return new BookingResource($booking);
        }
        return response([MainContract::MESSAGE  =>  'Something Goes Wrong'],400);
    }

    /**
     * @throws ValidationException
     */
    public function card(BookingPaymentCardRequest $bookingPaymentCardRequest)
    {
        $booking    =   $this->bookingService->create($bookingPaymentCardRequest->validated());
        if ($card   =   $this->paymentService->cardAddBooking($booking->{MainContract::USER_ID},$booking->{MainContract::ID})) {
            return $card;
        }
        return response(['message'  =>  'Произошла ошибка'],400);
    }

    /**
     * @throws ValidationException
     */
    public function ids($date, BookingIdsRequest $bookingIdsRequest): array
    {
        return $this->bookingService->ids($date, $bookingIdsRequest->validated()[MainContract::IDS]);
    }

    /**
     * @throws ValidationException
     */
    public function update($id, BookingUpdateRequest $bookingUpdateRequest):void
    {
        $this->bookingService->update($id, $bookingUpdateRequest->validated());
    }

    public function getById($id)
    {
        if ($booking = $this->bookingService->getById($id)) {
            return new BookingResource($booking);
        }
        return response([MainContract::MESSAGE  =>  'Booking Not Found'],404);
    }

    /**
     * @throws ValidationException
     */
    public function getByUserId($userId, BookingPaginateRequest $bookingPaginateRequest):object
    {
        return new BookingCollection($this->bookingService->getByUserId($userId,$bookingPaginateRequest->validated()[MainContract::PAGINATE]));
    }

    /**
     * @throws ValidationException
     */
    public function getByOrganizationId($organizationId, BookingPaginateRequest $request):object
    {
        return new BookingCollection($this->bookingService->getByOrganizationId($organizationId, $request->validated()[MainContract::PAGINATE]));
    }

    /**
     * @throws ValidationException
     */
    public function getByTableId($tableId, BookingPaginateRequest $bookingPaginateRequest):object
    {
        return new BookingCollection($this->bookingService->getByTableId($tableId, $bookingPaginateRequest->validated()[MainContract::PAGINATE]));
    }

    /**
     * @throws ValidationException
     */
    public function getByDate($date, BookingPaginateRequest $bookingPaginateRequest):object
    {
        return new BookingCollection($this->bookingService->getByDate($date, $bookingPaginateRequest->validated()[MainContract::PAGINATE]));
    }

    /**
     * @throws ValidationException
     */
    public function guest(BookingGuestRequest $bookingGuestRequest)
    {
        $data   =   $bookingGuestRequest->validated();
        $user   =   $this->userService->getById($data[MainContract::USER_ID]);

        if ($user->{MainContract::CODE} !== $data[MainContract::CODE]) {
            return response([MainContract::MESSAGE  =>  'Не правильный код'],400);
        }

        $user->{MainContract::PHONE_VERIFIED_AT}    =   date('Y-m-d H:i:s');
        $user->save();

        $booking    =   $this->bookingService->create($data);

        if ($booking->{MainContract::PRICE} > 0) {

            $payment    =   $this->paymentService->urlAdmin(
                $booking->{MainContract::ID},
                $booking->{MainContract::PRICE},
                $data[MainContract::TITLE],
                $user->{MainContract::PHONE}
            );

            if (array_key_exists(MainContract::PG_REDIRECT_URL,$payment)) {
                $booking->{MainContract::PAYMENT_URL}    =   $payment[MainContract::PG_REDIRECT_URL];
                $booking->save();
            }

        }

        return new BookingResource($booking);
    }

}
