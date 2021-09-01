<?php

namespace App\Jobs;

use App\Events\OrganizationProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Iiko;

use App\Helpers\Iiko\Iiko as IikoHelper;

class OrganizationInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $iiko;

    public function __construct(Iiko $iiko)
    {
        $this->iiko =   $iiko;
    }

    public function handle(IikoHelper $iiko)
    {
        $iiko->getRooms($this->iiko);
    }
}
