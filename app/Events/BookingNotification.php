<?php

namespace App\Events;

use App\Domain\Contracts\BookingContract;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $booking;

    public function __construct($booking)
    {
        $this->booking  =   $booking;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('booking.notification.'.$this->booking->user_id);
    }

    public function broadcastAs(): string
    {
        return 'booking.completed';
    }
}
