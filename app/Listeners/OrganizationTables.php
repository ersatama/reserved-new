<?php

namespace App\Listeners;

use App\Events\OrganizationProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Api\ApiService;

class OrganizationTables
{
    protected $apiService;

    /**
     * Create the event listener.
     *
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService   =   $apiService;
    }

    /**
     * Handle the event.
     *
     * @param  OrganizationProcessed  $event
     * @return void
     */
    public function handle(OrganizationProcessed $event)
    {
        $this->apiService->getRooms($event->organization);
    }
}
