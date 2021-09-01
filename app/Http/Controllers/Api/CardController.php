<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\Card\CardService;
use App\Services\Payment\PaymentService;
use App\Services\Booking\BookingService;
use App\Http\Requests\Card\CardPostRequest;
use App\Http\Requests\Card\CardUpdateRequest;
use App\Http\Resources\Card\CardResource;
use App\Http\Resources\Card\CardCollection;
use App\Domain\Contracts\MainContract;
use App\Jobs\CardDelete;
use App\Events\CardNotification;
use App\Models\Booking;

class CardController extends Controller
{
    protected $cardService;
    protected $paymentService;
    protected $bookingService;

    public function __construct(CardService $cardService, PaymentService $paymentService, BookingService $bookingService)
    {
        $this->cardService  =   $cardService;
        $this->paymentService   =   $paymentService;
        $this->bookingService   =   $bookingService;
    }

    /**
     * @throws ValidationException
     */
    public function booking($bookingId, CardPostRequest $cardPostRequest)
    {
        $cardPostRequest    =   $cardPostRequest->validated()[MainContract::PG_XML];
        if ($cardPostRequest && array_key_exists(MainContract::PG_STATUS,$cardPostRequest) && $cardPostRequest[MainContract::PG_STATUS] === MainContract::SUCCESS) {
            $card   =   $this->cardService->create([
                MainContract::USER_ID   =>  $cardPostRequest[MainContract::PG_USER_ID],
                MainContract::CARD_ID   =>  $cardPostRequest[MainContract::PG_CARD_ID],
                MainContract::HASH      =>  $cardPostRequest[MainContract::PG_CARD_HASH],
                MainContract::MONTH     =>  $cardPostRequest[MainContract::PG_CARD_MONTH],
                MainContract::YEAR      =>  $cardPostRequest[MainContract::PG_CARD_YEAR],
                MainContract::BANK      =>  $cardPostRequest[MainContract::PG_BANK],
                MainContract::COUNTRY   =>  $cardPostRequest[MainContract::PG_COUNTRY],
                MainContract::CARD_3D   =>  $cardPostRequest[MainContract::PG_CARD_3DS],
            ]);
            Booking::where(MainContract::ID,$bookingId)->update([
                MainContract::CARD_ID   =>  $cardPostRequest[MainContract::PG_CARD_ID],
                MainContract::STATUS    =>  MainContract::CHECKING
            ]);
            $booking    =   Booking::where(MainContract::ID,$bookingId)->first();
            if ($booking->{MainContract::PRICE} > 0) {
                $this->paymentService->create($booking);
            }
            event(new CardNotification($card));
        }
    }

    /**
     * @throws ValidationException
     */
    public function create(CardPostRequest $cardPostRequest)
    {
        $cardPostRequest    =   $cardPostRequest->validated()[MainContract::PG_XML];
        if ($cardPostRequest && array_key_exists(MainContract::PG_STATUS,$cardPostRequest) && $cardPostRequest[MainContract::PG_STATUS] === MainContract::SUCCESS) {
            $card   =   $this->cardService->create([
                MainContract::USER_ID   =>  $cardPostRequest[MainContract::PG_USER_ID],
                MainContract::CARD_ID   =>  $cardPostRequest[MainContract::PG_CARD_ID],
                MainContract::HASH      =>  $cardPostRequest[MainContract::PG_CARD_HASH],
                MainContract::MONTH     =>  $cardPostRequest[MainContract::PG_CARD_MONTH],
                MainContract::YEAR      =>  $cardPostRequest[MainContract::PG_CARD_YEAR],
                MainContract::BANK      =>  $cardPostRequest[MainContract::PG_BANK],
                MainContract::COUNTRY   =>  $cardPostRequest[MainContract::PG_COUNTRY],
                MainContract::CARD_3D   =>  $cardPostRequest[MainContract::PG_CARD_3DS],
            ]);
            event(new CardNotification($card));
        }
    }

    /**
     * @throws ValidationException
     */
    public function update($id, CardUpdateRequest $request)
    {
        if ($card   =   $this->cardService->getById($id)) {
            $this->cardService->update($id, $request->validated());
            if ($card->{MainContract::STATUS} === MainContract::OFF) {
                CardDelete::dispatch($card);
            }
            return new CardResource($card);
        }
        return response(['message'  =>  'Card Not Found'],400);
    }

    public function getById($id)
    {
        if ($card   =   $this->cardService->getById($id)) {
            return new CardResource($card);
        }
        return response(['message'  =>  'Card Not Found'],400);
    }

    public function getByUserId($userId): CardCollection
    {
        return new CardCollection($this->cardService->getByUserId($userId));
    }
}
