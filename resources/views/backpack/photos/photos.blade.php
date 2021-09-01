@extends(backpack_view('blank'))
@section('content')
    <link href="{{ asset('css/photos.css') }}" rel="stylesheet">
    <div id="app">
        <div class="photos">
            <input type="hidden" id="organization" value="{{$id}}">
            <div class="photos-main">
                <div class="photos-title">
                    Фотографии
                    <span v-if="photos.length > 0">(@{{ photos.length }})</span>
                    <button class="photos-btn" @click="newPhoto(0)">Добавить фото</button>
                </div>
            </div>
        </div>
        <div class="photos">
            <div class="photos-table" v-if="photos.length > 0">
                <div class="photos-item" v-for="(photo,key) in photos" :style="{'background-image': 'url('+photo.image+')'}" @click="imageView(key)"></div>
            </div>
            <div class="photo-empty" v-else>
                Пусто
            </div>
        </div>
        @include('backpack.modal.photos')
    </div>
    @include('backpack.scripts')
    <script src="{{ asset('js/photos.js') }}"></script>
@endsection
