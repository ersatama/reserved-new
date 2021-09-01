@extends(backpack_view('layouts.plain'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-center mt-2 mb-3">{{ trans('backpack::base.access_restricted') }}</h3>
                    <h5 class="text-danger p-2">{{ trans('backpack::base.you_are_blocked') }}</h5>
                    <a href="/exit">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 mt-3">Выйти</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
