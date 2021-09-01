<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Request;
use App\Services\Payment\PaymentService;
use App\Services\Booking\BookingService;

use App\Domain\Contracts\BookingContract;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $bookingService;
    public function __construct(PaymentService $paymentService, BookingService $bookingService)
    {
        $this->paymentService   =   $paymentService;
        $this->bookingService   =   $bookingService;
    }

    public function form($bookingId)
    {
        if ($booking    =   $this->bookingService->getById($bookingId)) {
            if ($booking->{MainContract::PAYMENT_ID}) {
                $payment    =   PaymentService::paySignature($booking->{MainContract::PAYMENT_ID});
                return view('payment.form',compact('payment','booking'));
            }
            return response(['message'  =>  'Booking Payment Id Not Found'],404);
        }
        return response(['message'  =>  'Booking Not Found'],404);
    }
}
