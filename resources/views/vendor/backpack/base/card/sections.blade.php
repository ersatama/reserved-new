@foreach($organizationTableService->getByOrganizationId($organization->id) as & $section)
    <h3 class="my-3">{{$section->name}}</h3>

    <div class="row">
        @foreach($organizationTableListService->getByTableId($section->id) as &$table)
            <div class="col-xl-2 col-lg-4 col-md-6 col-6">
                @include('vendor.backpack.base.card.card',[
                    'table' =>  $table,
                    'userService'   =>  $userService,
                    'booking' => $bookingService->getLastByTableId($table->id, $date, $organization->timezone),
                    'organization' => $organization,
                    'user_id' => $user_id
                ])
            </div>
        @endforeach
    </div>
@endforeach
