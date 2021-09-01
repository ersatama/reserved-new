<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentResultRequest;
use Illuminate\Http\Request;

use App\Services\Payment\PaymentService;
use App\Services\Booking\BookingService;
use App\Services\Api\ApiService;

use App\Domain\Contracts\BookingContract;
use App\Http\Requests\Payment\PaymentCardResultRequest;
use Illuminate\Support\Facades\Log;

use App\Helpers\Iiko\Iiko;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller {

    protected $iiko;
    protected $paymentService;
    protected $bookingService;
    protected $apiService;

    public function __construct(Iiko $iiko, PaymentService $paymentService, BookingService $bookingService, ApiService $apiService)
    {
        $this->iiko =   $iiko;
        $this->paymentService   =   $paymentService;
        $this->bookingService   =   $bookingService;
        $this->apiService       =   $apiService;
    }

    public function card($id) {
        if ($card   =   $this->paymentService->cardAdd($id)) {
            return $card;
        }
        return response(['message'  =>  'Произошла ошибка'],400);
    }

    /**
     * @throws ValidationException
     */
    public function cardResult(PaymentCardResultRequest $paymentCardResultRequest):void
    {
        $data   =   $paymentCardResultRequest->validated();
        if ((int)$data[MainContract::PG_RESULT] === 1) {
            $this->bookingService->update($data[MainContract::PG_ORDER_ID],[
                MainContract::STATUS    =>  MainContract::ON
            ]);
        } else {
            $this->bookingService->update($data[MainContract::PG_ORDER_ID],[
                MainContract::STATUS    =>  MainContract::OFF
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function result(PaymentResultRequest $paymentResultRequest):void
    {
        $data   =   $paymentResultRequest->validated();
        Log::info('payment info',$data);
        if ($this->bookingService->result($data)) {
            //$this->iiko->booking($data[MainContract::PG_ORDER_ID]);
        }
    }
}
