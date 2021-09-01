<?php

namespace App\Jobs;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\OrganizationContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Booking;

use App\Services\Organization\OrganizationService;
use App\Services\Telegram\TelegramService;

use App\Helpers\Telegram\Telegram;

class TelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $booking;
    public function __construct(Booking $booking)
    {
        $this->booking  =   $booking;
    }

    public function handle(OrganizationService $organizationService, TelegramService $telegramService, Telegram $telegram)
    {
        $organization   =   $organizationService->getById($this->booking->{BookingContract::ORGANIZATION_ID});
        $telegram->booking($telegramService->getByUserId($organization->{OrganizationContract::USER_ID}), $this->booking);
    }
}
