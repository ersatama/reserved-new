<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

use App\Helpers\Sms\Sms;

class UserPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $password;
    protected $booking;

    public function __construct(User $user, string $password, $booking = null)
    {
        $this->user =   $user;
        $this->password =   $password;
        $this->booking  =   $booking;
    }

    public function handle(Sms $sms)
    {
        $sms->password($this->user,$this->password,$this->booking);
    }
}
