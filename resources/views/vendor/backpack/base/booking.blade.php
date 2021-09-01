@extends(backpack_view('blank'))
@section('content')

    <div class="row">
        <div class="col">
            <h3 class="my-3">Бронирование</h3>
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb bg-transparent p-0 m-0">
                    <li class="breadcrumb-item"><a href="/admin/dashboard/">Главная</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$table->title}}</li>
                </ol>
            </nav>
            <form style="max-width: 500px;">
                @csrf
                <input type="hidden" name="{{\App\Domain\Contracts\BookingContract::ORGANIZATION_ID}}" value="{{$table->organization_id}}">
                <input type="hidden" name="{{\App\Domain\Contracts\BookingContract::ORGANIZATION_TABLE_ID}}" value="{{$table->organization_table_id}}">
                <div class="form-group">
                    <label for="formGroupExampleInput">Пользователь</label>
                    <div class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModalLong">Выбрать</div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Начало</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Конец</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Дата</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Статус</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Комментарии</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-success btn-block">Забронировать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
