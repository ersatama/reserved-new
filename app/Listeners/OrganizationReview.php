<?php

namespace App\Listeners;

use App\Events\ReviewCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Organization\OrganizationService;

class OrganizationReview
{
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService  =   $organizationService;
    }

    public function handle(ReviewCreated $event)
    {
        $this->organizationService->updateRating($event->review->organization_id);
    }
}
