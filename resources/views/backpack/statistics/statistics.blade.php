@extends(backpack_view('blank'))
@section('content')
    <link href="{{ asset('css/entity.css') }}" rel="stylesheet">
    <div id="app">
        <div class="entity">
            <input type="hidden" id="organization" value="{{$id}}">
            <div class="entity-main">
                <div class="entity-header">
                    <div class="entity-title">Статистика</div>
                </div>
            </div>
            <div class="entity-filter" @click="showModal  =   true"></div>
        </div>
        <div class="entity-blocks">
            <div class="entity-block">
                <div class="entity-block-title">Сайты</div>
                <div class="entity-block-description">Статистика за посещении вашего заведения со сторонних сайтов</div>
                <div class="entity-block-body" v-html="lineChart">

                </div>
            </div>
            <div class="entity-block">
                <div class="entity-block-title">Бронирование</div>
                <div class="entity-block-description">Статистика бронировании</div>
                <div class="entity-block-body" v-html="barChart">

                </div>
            </div>
        </div>
        <div class="entity-blocks">
            <div class="entity-block">
                <div class="entity-block-title">Рейтинг</div>
                <div class="entity-block-description">Рейтинг вашего заведения основанных на отзыве</div>
                <div class="entity-block-body" v-html="pieChart">

                </div>
            </div>
        </div>
        @include('backpack.modal.statistics')
    </div>
    @include('backpack.scripts')
    <script src="{{ asset('js/statistics.js') }}"></script>
@endsection
