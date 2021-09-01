<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Booking;

use App\Services\Payment\PaymentService;

class BookingPaymentRevoke implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $booking;
    public function __construct(Booking $booking)
    {
        $this->booking  =   $booking;
    }

    public function handle(PaymentService $paymentService)
    {
        $paymentService->revoke($this->booking);
    }
}
