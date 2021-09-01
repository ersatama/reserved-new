<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Payment\PaymentService;
use App\Models\Card;

class CardDelete implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $card;

    public function __construct(Card $card)
    {
        $this->card =   $card;
    }

    public function handle(PaymentService $paymentService)
    {
        $paymentService->cardDelete($this->card);
    }
}
