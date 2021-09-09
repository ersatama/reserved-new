<template>
    <div class="container d-md-none">
        <div class="row bg-white width-auto footer-fixed d-flex justify-content-center">
            <div class="col-12 col-md-4 p-0">
                <div class="footer-fixed-main w-100">
                    <a href="/home" class="footer-icon p-0 py-1">
                        <button class="btn font-weight-bold w-100" :class="{'footer-icon-center':(this.url==='home')}">
                            <img src="/img/logo/home.svg" class="footer-img">
                            <div class="title">Категории</div>
                        </button>
                    </a>
                    <a href="/news" class="footer-icon p-0 py-1">
                        <button class="btn font-weight-bold w-100" :class="{'footer-icon-center':(this.url==='news')}">
                            <img src="/img/logo/newspaper.svg" class="footer-img">
                            <div class="title">Новости</div>
                        </button>
                    </a>
                    <a class="footer-icon p-0 py-1" v-if="storage.token"  @click="view(1)">
                        <button class="btn font-weight-bold w-100" :class="{'footer-icon-center-notify': (storage.sidebar.notifications > 0)}">
                            <img src="/img/logo/notification.svg" class="footer-img" v-if="storage.sidebar.notifications > 0">
                            <img src="/img/logo/bell.svg" class="footer-img" v-else>
                            <div class="title">Уведомления</div>
                        </button>
                    </a>
                    <a class="footer-icon p-0 py-1" data-toggle="modal" data-target="#auth_modal" v-else>
                        <button class="btn font-weight-bold w-100">
                            <img src="/img/logo/bell.svg" class="footer-img">
                            <div class="title">Уведомления</div>
                        </button>
                    </a>
                    <a href="/favorite" class="footer-icon p-0 py-1">
                        <button class="btn font-weight-bold w-100" :class="{'footer-icon-center':(this.url==='favorite')}">
                            <img src="/img/logo/favorite.svg" class="footer-img">
                            <div class="title">Избранное</div>
                        </button>
                    </a>
                    <a href="/profile" class="footer-icon p-0 py-1" v-if="storage.token">
                        <button class="btn font-weight-bold w-100" :class="{'footer-icon-center':(this.url==='profile')}">
                            <img src="/img/logo/profile.svg" class="footer-img">
                            <div class="title">Профиль</div>
                        </button>
                    </a>
                    <a class="footer-icon p-0 py-1" data-toggle="modal" data-target="#auth_modal" v-else>
                        <button class="btn font-weight-bold w-100">
                            <img src="/img/logo/profile.svg" class="footer-img">
                            <div class="title">Профиль</div>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FooterMenu",
    data() {
        return {
            end: '',
            url: ''
        }
    },
    created() {
        this.setEnd();
    },
    methods: {
        view: function(index) {
            this.storage.sidebar.view   =   index;
            this.storage.sidebar.show   =   true;
        },
        setEnd: function() {
            let path    =   window.location.pathname.split('/');
            this.url    =   path[ path.length - 1 ];
            let length  =   path.length;
            for (let i = 0; i < length; i++) {
                if (path[i].trim() !== '') {
                    this.end    =   path[i];
                    break;
                }
            }
        },
    }
}
</script>

<style lang="scss">
    @import '../../../css/footerMenu/footerMenu.scss';
</style>
