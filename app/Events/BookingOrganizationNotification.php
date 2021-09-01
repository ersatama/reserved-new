<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingOrganizationNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $booking;

    public function __construct($booking)
    {
        $this->booking  =   $booking;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('booking.notification.organization.'.$this->booking->organization_id);
    }


    public function broadcastAs(): string
    {
        return 'booking.organization.completed';
    }
}
