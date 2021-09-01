<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Telegram\TelegramService;
use App\Helpers\Telegram\Telegram;
use App\Models\Review;

class TelegramReviewNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $review;
    protected $booking;
    public function __construct(Review $review, $booking)
    {
        $this->review   =   $review;
        $this->booking  =   $booking;
    }

    public function handle(TelegramService $telegramService, Telegram $telegram)
    {
        $telegram->review($telegramService->getByUserId($this->booking->organization->user_id), $this->review, $this->booking);
    }
}
