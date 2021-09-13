@extends(backpack_view('blank'))

@section('content')
    <link href="{{ asset('css/news.css') }}" rel="stylesheet">
    <div id="app">
        <div class="news">
            <input type="hidden" id="organization" value="{{$id}}">
            <div class="news-main">
                <div class="news-title">
                    новости
                    <span v-if="news.length > 0">(@{{ news.length }})</span>
                    <button class="news-btn" @click="add()">Добавить новость</button>
                </div>
            </div>
        </div>
        <div class="news-all" v-if="news.length > 0">
            <div class="news-item" v-for="(item,key) in news" :key="key">
                <div class="news-wallpaper">
                    <div class="news-wallpaper-image" v-if="item.images.length > 0" :style="{'background-image':'url('+item.images[0].image+')'}"></div>
                    <div class="news-layer">
                        <div class="news-layer-status" v-if="item.status === 'CHECKING'">На проверке</div>
                        <div class="news-layer-title">@{{ item.title }}</div>
                        <div class="news-layer-description">@{{ item.description }}</div>
                        <div class="news-layer-btn">
                            <button class="news-layer-btn-delete" @click="deleteNews(key)">Удалить</button>
                            <button class="news-layer-btn-edit" @click="editNews(key)">Редактировать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backpack.modal.news')
    </div>
    @include('backpack.scripts')
    <script src="{{ asset('js/news.js') }}"></script>
@endsection
