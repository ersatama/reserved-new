<div class="row justify-content-center">
    <div class="col-md-3 col-12">
        <div class="row mt-3">
            <div class="col">
                <input type="text" class="form-control w-100 text-center border-0 shadow-sm bg-white font-weight-bold" readonly id="datepicker" value="{{$date?$date:\App\Helpers\Time\Time::currentDateTimezone($organization->{\App\Domain\Contracts\MainContract::TIMEZONE})}}" data-id="{{$organization->id}}">
            </div>
        </div>
    </div>
</div>
<h1 class="my-3 text-center font-weight-bold text-primary">{{$organization->title}}</h1>
<p class="text-center h5 text-secondary">Выберите стол для бронирования</p>
<div id="sections">
    @include('vendor.backpack.base.card.sections',[
        'organizationTableService'  =>  $organizationTableService,
        'organizationTableListService'   =>  $organizationTableListService,
        'bookingService'    =>  $bookingService,
        'userService'   =>  $userService,
        'organization'  =>  $organization,
        'date'  =>  ($date?$date:\App\Helpers\Time\Time::currentDateTimezone($organization->{\App\Domain\Contracts\MainContract::TIMEZONE})),
        'user_id' => $user_id,
    ]);
</div>
