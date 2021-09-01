<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CardNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $card;
    public function __construct($card)
    {
        $this->card =   $card;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('new.card.'.$this->card->user_id);
    }

    public function broadcastAs(): string
    {
        return 'new.card';
    }
}
