<?php

namespace App\Jobs;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\PaymentContract;
use App\Services\Organization\OrganizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Services\Payment\PaymentService;
use App\Services\Sms\SmsService;
use App\Services\User\UserService;
use App\Services\Booking\BookingService;

class BookingPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    public function __construct($data) {
        $this->data  =   $data;
    }

    public function handle(OrganizationService $organizationService, SmsService $smsService, UserService $userService, PaymentService $paymentService, BookingService $bookingService) {
        $organization   =   $organizationService->getById($this->data[MainContract::ORGANIZATION_ID]);
        $user           =   $userService->getById($this->data[MainContract::USER_ID]);
        $payment        =   $paymentService->urlAdmin($this->data[MainContract::ID],$this->data[MainContract::PRICE],$organization->title,$user->phone);
        if (array_key_exists(MainContract::PG_REDIRECT_URL,$payment)) {
            $bookingService->update($this->data[MainContract::ID],[
                MainContract::PAYMENT_ID     =>  $payment[MainContract::PG_PAYMENT_ID],
                MainContract::PAYMENT_URL    =>  $payment[MainContract::PG_REDIRECT_URL]
            ]);
            $smsService->sendBooking($user->phone,$organization->title,$payment[MainContract::PG_REDIRECT_URL]);
        }
    }
}
