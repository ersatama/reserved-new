<div class="card shadow border-0" data-card="{{$table->id}}" style="border-radius: 10px;">
    <div class="card-toggle-btn @if($table->status === \App\Domain\Contracts\BookingContract::FROZEN) card-toggle-btn-locked @else card-toggle-btn-success @endif" data-id="{{$table->id}}" data-status="{{$table->status}}"></div>
@if($booking && $booking->status !== \App\Domain\Contracts\BookingContract::COMPLETED)
    @php
        $user =   $userService->getById($booking->user_id);
    @endphp
        <div class="card-header bg-info font-weight-bold text-center h6 border-0">
            <div class="w-100 d-flex justify-content-center">
                {{$table->title}}
                <span class="text-dark card-id">{{$booking->id}}</span>
            </div>
        </div>
        <ul class="list-group list-group-flush" style="font-size: 13px;">
            <li class="list-group-item">
                <span class="text-secondary">Имя</span> -
                <span class="font-weight-bold text-dark">{{$user->name}}</span>
            </li>
            <li class="list-group-item">
                <span class="text-secondary">Номер</span> -
                <span class="font-weight-bold text-dark">{{$user->phone}}</span>
            </li>
            <li class="list-group-item">
                <span class="text-secondary">Время</span> -
                <span class="font-weight-bold text-dark">{{$booking->time}}</span>
            </li>
        </ul>
        <div class="card-body" data-id="{{$organization->id}}" data-user="{{$user_id}}">

        @if($booking->status === \App\Domain\Contracts\BookingContract::CHECKING)
            <a class="btn btn-info btn-block text-white font-weight-bold">В резерве</a>
        @elseif($booking->status === \App\Domain\Contracts\BookingContract::ON)
            <a class="btn btn-info btn-block text-white font-weight-bold btn-booking-came" data-id="{{$booking->id}}">Гость пришел</a>
        @elseif($booking->status === \App\Domain\Contracts\BookingContract::CAME)
            <a class="btn btn-dark btn-block text-white font-weight-bold btn-booking-completed" data-id="{{$booking->id}}">Завершить</a>
        @endif

        <a class="btn btn-dark btn-block text-white font-weight-bold btn-booking" data-id="{{$booking->id}}">Отменить</a>
        </div>

@else
        <div class="card-header bg-success font-weight-bold text-center h6 border-0">{{$table->title}}</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-center text-secondary">
                <a class="nav-link p-0">
                    <i class="nav-icon la la-users h2"></i><br>
                    Вместимость <span class="text-dark font-weight-bold">{{$table->limit}}</span>
                </a>
            </li>
        </ul>
        <div class="card-body" data-id="{{$organization->id}}" data-user="{{$user_id}}">
            <a href="/admin/booking/create?table={{$table->id}}" class="btn btn-success btn-block text-white font-weight-bold booking-new-btn" data-toggle="modal" data-target="#booking-modal" data-id="{{$table->id}}">Свободно</a>
        </div>
@endif
</div>
