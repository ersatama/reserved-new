<template>
    <breadcrumb :breadcrumb="breadcrumb"></breadcrumb>
    <div class="container-fluid section-bg-main" v-if="end === 'profile'">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card text-center border-0 rounded-0 bg-transparent">
                        <div class="card-header top-bg border-0 d-flex justify-content-center">
                            <ul class="nav nav-tabs card-header-tabs border-0 font-weight-bold">
                                <li class="nav-item">
                                    <a class="nav-link border-0" href="/profile" :class="{ active: (url==='profile'),disabled: (url==='profile'),'text-dark': (url!=='profile') }">
                                        <img src="/img/logo/profile-white.svg" width="20" height="20" class="d-md-none" v-if="url!=='profile'">
                                        <img src="/img/logo/profile.svg" width="20" height="20" class="d-md-none" v-else>
                                        <span class="d-none d-md-block">Профиль</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-0" href="/profile/settings" :class="{ active: (url==='settings'),disabled: (url==='settings'),'text-dark': (url!=='settings') }">
                                        <img src="/img/logo/settings-white.svg" width="20" height="20" class="d-md-none" v-if="url!=='settings'">
                                        <img src="/img/logo/settings.svg" width="20" height="20" class="d-md-none" v-else>
                                        <span class="d-none d-md-block">Настройки</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-0" href="/profile/history" :class="{ active: (url==='history'),disabled: (url==='history'),'text-dark': (url!=='history') }">
                                        <img src="/img/logo/history-white.svg" width="20" height="20" class="d-md-none" v-if="url!=='history'">
                                        <img src="/img/logo/history.svg" width="20" height="20" class="d-md-none" v-else>
                                        <span class="d-none d-md-block">История</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-0" href="/profile/payments" :class="{ active: (url==='payments'),disabled: (url==='payments'),'text-dark': (url!=='payments') }">
                                        <img src="/img/logo/wallet-white.svg" width="20" height="20" class="d-md-none" v-if="url!=='payments'">
                                        <img src="/img/logo/wallet.svg" width="20" height="20" class="d-md-none" v-else>
                                        <span class="d-none d-md-block">Способ оплаты</span>
                                    </a>
                                </li>
                                <!--
                                <li class="nav-item">
                                    <a class="nav-link text-white border-0" href="/profile/support" :class="{ active: (url==='support'?true:false),disabled: (url==='support'?true:false),'text-white': (url!=='support'?true:false) }">
                                        <img src="/img/logo/help-white.svg" width="20" height="20" class="d-md-none" v-if="url!=='support'">
                                        <img src="/img/logo/help.svg" width="20" height="20" class="d-md-none" v-else>
                                        <span class="d-none d-md-block">Служба Поддержки</span>
                                    </a>
                                </li>
                                -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid section-bg-main" v-else-if="end === 'form'">

    </div>
</template>

<script>
import Breadcrumb from '../layout/Breadcrumb';
export default {
    props: ['category','name','id'],
    name: "ProfileSection",
    components: {
        Breadcrumb
    },
    data() {
        return {
            url: '',
            end: '',
            breadcrumb: []
        }
    },
    watch: {
        category: function() {
            this.setBreadcrumb();
        },
        name: function() {
            this.setBreadcrumb();
        }
    },
    created() {
        this.setEnd();
        this.setBreadcrumb();
    },
    methods: {
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
        setBreadcrumb: function() {
            this.breadcrumb =   [];
            let link    =   '';
            if (this.end === 'form') {
                this.breadcrumb.push({
                    title: 'Заявка для ресторанов',
                    link: link+'form'
                });
            } else if (this.end === 'profile') {
                this.breadcrumb.push({
                    title: 'Профиль',
                    link: link+'profile'
                });
                link    +=  'profile/';
                if (this.url === 'settings') {
                    this.breadcrumb.push({
                        title: 'Настройки',
                        link: link+'settings'
                    });
                    link    +=  'settings/';
                } else if (this.url === 'history') {
                    this.breadcrumb.push({
                        title: 'История',
                        link: link+'history'
                    });
                    link    +=  'history/';
                } else if (this.url === 'payments') {
                    this.breadcrumb.push({
                        title: 'Способ оплаты',
                        link: link+'payments'
                    });
                    link    +=  'payments/';
                }
            } else if (this.end === 'favorite') {
                this.breadcrumb.push({
                    title: 'Избранное',
                    link: link+'favorite'
                });
                link    +=  'favorite/';
            } else if (this.end === 'top') {
                this.breadcrumb.push({
                    title: 'Новости',
                    link: link+'top'
                });
                link    +=  'top/';
            } else if (this.end === 'home') {
                this.breadcrumb.push({
                    title: 'Категории',
                    link: link+'home'
                });
                link    +=  'home/';
                if (this.category) {
                    this.breadcrumb.push({
                        title: this.category.title,
                        link: link+this.category.slug
                    });
                    link    +=  this.category.slug+'/';
                }
                if (this.id) {
                    this.breadcrumb.push({
                        title: this.name,
                        link: link+this.id
                    });
                    link    +=  this.id+'/';
                }
            }
        },
    }
}
</script>

<style lang="scss">
  @import '../../../css/sections/profileSection.scss';
</style>
