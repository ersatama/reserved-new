@extends(backpack_view('layouts.plain'))
@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4">
            <h3 class="text-center mb-4">{{ trans('backpack::base.verify_phone') }}</h3>
            <div class="card">
                <div class="card-body">
                    <form class="col-md-12 p-t-10" role="form" method="POST" action="{{ route('phone.verify') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label class="control-label" for="{{\App\Domain\Contracts\UserContract::CODE}}">{{ trans('backpack::base.sms_code') }}</label>
                            <div>
                                <input type="text" class="form-control{{ $errors->has(\App\Domain\Contracts\UserContract::CODE) ? ' is-invalid' : '' }}" name="{{\App\Domain\Contracts\UserContract::CODE}}" id="{{\App\Domain\Contracts\UserContract::CODE}}" value="{{ old(\App\Domain\Contracts\UserContract::CODE) }}">
                                @if ($errors->has(\App\Domain\Contracts\UserContract::CODE))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first(\App\Domain\Contracts\UserContract::CODE) }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div>
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ trans('backpack::base.verify_code') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $("#code").mask("999999");
        </script>
    </div>
@endsection
