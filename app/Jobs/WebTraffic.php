<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\WebTraffic\WebTrafficService;

class WebTraffic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $date;
    protected $id;
    protected $ip;
    protected $url;
    protected $webTrafficService;

    public function __construct($date,$id,$ip,$url)
    {
        $this->date =   $date;
        $this->id   =   $id;
        $this->ip   =   $ip;
        $this->url  =   $url;
    }

    public function handle(WebTrafficService $webTrafficService)
    {
        if (!$webTrafficService->getByDateAndOrganizationIdAndIpAndWeb($this->date,$this->id,$this->ip,$this->url)) {
            $webTrafficService->create([
                MainContract::ORGANIZATION_ID   =>  $this->id,
                MainContract::WEBSITE   =>  $this->url,
                MainContract::IP    =>  $this->ip,
            ]);
        }
    }
}
