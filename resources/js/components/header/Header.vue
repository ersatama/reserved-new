<template>
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container-fluid">
                <div class="container p-0">
                    <div class="header-reserved d-sm-block d-md-none"></div>
                    <a class="navbar-brand text-uppercase font-weight-bold header-text px-0 d-sm-block d-md-none" data-toggle="modal" data-target="#location">
                        <span v-if="storage.city">{{storage.city.title}}</span>
                        <span v-else>Не выбрано</span>
                    </a>
                    <a class="navbar-brand text-uppercase font-weight-bold header-text px-0 d-none d-md-block">
                        RESERVED
                    </a>
                    <div class="header-sign-out d-sm-block d-md-none" v-if="!login" @click="exit"></div>
                    <div id="navbarSupportedContent" class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item mx-3 ">
                                <a href="/home" class="btn nav-link font-weight-bold font-menu">
                                    <div>Категории</div>
                                </a>
                            </li>
                            <li class="nav-item mx-3">
                                <a href="/news" class="btn nav-link font-weight-bold font-menu">
                                    <div>Новости</div>
                                </a>
                            </li>
                            <li class="nav-item mx-3">
                                <a href="/favorite" class="btn nav-link font-weight-bold font-menu">
                                    <div>Избранное</div>
                                </a>
                            </li>
<!--                            <li class="nav-item mx-3 account-top" v-show="!login">
                                <div class="account account-notification">
                                    <div class="account-main">
                                        <div class="account-list">
                                            <sidebar></sidebar>
                                        </div>
                                    </div>
                                </div>
                            </li>-->
                            <li class="nav-item mx-3 account-top">
                                <div class="account account-bag">
                                    <div class="account-main">
                                        <div class="account-list">
                                            <template v-if="login">
                                                <div class="account-list-title">Добро пожаловать</div>
                                                <div class="account-list-items">
                                                    <div class="account-list-item" data-toggle="modal" data-target="#auth_modal" @click="storage.auth = true">
                                                        <div class="account-list-item-icon account-list-item-icon-account"></div>
                                                        <div class="account-list-item-title">Войти</div>
                                                    </div>
                                                    <div class="account-list-item" data-toggle="modal" data-target="#auth_modal" @click="storage.auth = false">
                                                        <div class="account-list-item-icon account-list-item-icon-register"></div>
                                                        <div class="account-list-item-title">Регистрация</div>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-else-if="user">
                                                <div class="account-info">
                                                    <div class="account-info-logo">
                                                        <div>{{user.name[0]}}</div>
                                                    </div>
                                                    <div class="account-info-name">{{user.name}}</div>
                                                </div>
                                                <div class="account-list-items">
                                                    <a href="/profile" class="account-list-item">
                                                        <div class="account-list-item-icon account-list-item-icon-account"></div>
                                                        <div class="account-list-item-title">Профиль</div>
                                                    </a>
                                                    <a href="/profile/settings" class="account-list-item">
                                                        <div class="account-list-item-icon account-list-item-icon-settings"></div>
                                                        <div class="account-list-item-title">Настройки</div>
                                                    </a>
                                                    <a href="/profile/history" class="account-list-item">
                                                        <div class="account-list-item-icon account-list-item-icon-history"></div>
                                                        <div class="account-list-item-title">История бронирований</div>
                                                    </a>
                                                    <a href="/profile/payments" class="account-list-item">
                                                        <div class="account-list-item-icon account-list-item-icon-payments"></div>
                                                        <div class="account-list-item-title">Платежи</div>
                                                    </a>
                                                    <a class="account-list-item" @click="exit">
                                                        <div class="account-list-item-icon account-list-item-icon-sign_out"></div>
                                                        <div class="account-list-item-title">Выйти</div>
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--<li class="ml-3 d-flex">
                                    <div class="header-notification" :class="{'header-notification-icon-message':(storage.sidebar.notifications > 0),'header-notification-icon':(storage.sidebar.notifications === 0)}"  @click="view(1)"></div>
                                    <div class="header-main position-relative">
                                        <div class="header-profile" v-if="user.name">
                                            <div class="header-profile-main font-weight-bold text-capitalize">
                                                <div class="header-profile-main-content">
                                                    <div>{{user.name}}</div>
                                                </div>
                                            </div>
                                            <div class="header-profile-icon">
                                                <div class="text-white font-weight-bold">{{user.name[0]}}</div>
                                            </div>
                                        </div>
                                        <div class="header-dropdown overflow-hidden">
                                            <div class="list-group list-group-flush header-dropdown-ul">
                                                <a href="/profile" class="list-group-item text-decoration-none">Мой профиль</a>
                                                <a href="/profile/settings" class="list-group-item text-decoration-none">Настройки</a>
                                                <a href="/profile/history" class="list-group-item text-decoration-none">История</a>
                                                <a class="list-group-item text-decoration-none" @click="exit">Выйти</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <Auth></Auth>
    <sidebar></sidebar>
    <Footer-menu></Footer-menu>
</template>

<script>
import Auth from "./auth/Auth";
import Sidebar from '../layout/Sidebar';
import FooterMenu from '../footerMenu/FooterMenu';
export default {
    name: "Header",
    components: {
        Auth,
        Sidebar,
        FooterMenu
    },
    data() {
        return {
            notification: false,
            login: false,
            user: false,
            countries: [],
        }
    },
    async created() {
        this.notificationView();
        await this.auth();
        await this.getCountry();
    },
    methods: {
        getCountry: async function () {
            if (!sessionStorage.countries) {
                await axios.get('/api/countries')
                    .then(response => {
                        let data = response.data;
                        if (data.hasOwnProperty('data')) {
                            data = data.data;
                            this.countries = data;
                            sessionStorage.countries = JSON.stringify(data);
                            if (localStorage.getItem('vrs_') === null) {
                                this.storage.city = this.countries[0].city_id[0];
                                $('#location').modal('toggle');
                            } else {
                                let vrs_    =   JSON.parse(localStorage.getItem('vrs_'));
                                if (vrs_.city === '') {
                                    this.storage.city = this.countries[0].city_id[0];
                                    $('#location').modal('toggle');
                                } else {
                                    $('#location').modal('toggle');
                                }
                            }
                        }
                    }).catch(error => {
                        console.log(error.response);
                    });
            } else {
                this.countries = JSON.parse(sessionStorage.countries);
                if (this.storage.city === '') {
                    this.storage.city = this.countries[0].city_id[0];
                    $('#location').modal('toggle');
                }
            }
        },
        notificationView: function() {
            if (window.location.pathname !== '/profile/history') {
                this.notification   =   true;
            }
        },
        view: function(index) {
            this.storage.sidebar.view   =   index;
            this.storage.sidebar.show   =   true;
        },
        exit: function() {
            this.login  =   true;
            this.storage.token  =   '';
            sessionStorage.removeItem('user');
            this.user   =   false;
            window.location.href    = '/';
        },
        auth: async function () {
            if (this.storage.token) {
                if (sessionStorage.user) {
                    this.user = JSON.parse(sessionStorage.user);
                } else {
                    await axios.get('/api/token/' + this.storage.token)
                        .then(response => {
                            let data = response.data;
                            if (data.hasOwnProperty('data')) {
                                sessionStorage.user = JSON.stringify(data.data);
                                this.user = JSON.parse(sessionStorage.user);
                            }
                        }).catch(error => {
                            this.login = true;
                            this.storage.token = '';
                        });
                }
            } else {
                this.login = true;
            }
        }
    }
}
</script>

<style lang="scss">
    @import '../../../css/header/header.scss';
.btn {
    outline: none !important;
    box-shadow: none !important;
}

.btn-menu {
    & > a {
        padding-right: 15px !important;
        position: relative;
        cursor: pointer;
        &:after {
            content: '';
            position: absolute;
            width: 8px;
            height: 8px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            border-radius: 2px;
            right: 0;
            top: 16px;
            transform: rotate(45deg);
        }
    }
}
.btn, .btn-group {
    outline: none;
}
.register-btn {
    border-radius: 100px;
    text-align: center;
}
.font-menu {
    font-size: 14px;
    font-weight: 500;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    & > div {

    }
    &-item {
        color: #000;
        font-weight: normal;
        &:hover, &:active {
            background-color: #4ca1af;
            color: #FFF;
        }
    }
}
.logo {
    font-weight: bold;
    width: 34px;
    height: 34px;
    border-radius: 20px;
    margin: 0 2px 0 0;
    border: none;
    background: #fff;
    color: #2193b0;
    &-blue {
        background: #2193b0;
        color: #fff;
    }
}
@media only screen and (max-width : 992px) {
    .logo {
        background: #2193b0 !important;
        color: #fff !important;
        &-text {
            color: #2193b0;
        }
    }
}
.btn-register {
    background: #FF8008;
}
.navbar {
    transition: all 0.4s;
}

.navbar .nav-link {
    color: #fff;
}

.navbar .nav-link:hover,
.navbar .nav-link:focus {
    color: #fff;
    text-decoration: none;
}

.navbar .navbar-brand {
    color: #fff;
}


/* Change navbar styling on scroll */
.navbar.active {
    background: #fff;
    box-shadow: 1px 2px 10px rgba(0, 0, 0, 0.1);
}

.navbar.active .nav-link {
    color: #555;
}

.navbar.active .nav-link:hover,
.navbar.active .nav-link:focus {
    color: #555;
    text-decoration: none;
}

.navbar.active .navbar-brand {
    color: #555;
}


/* Change navbar styling on small viewports */
@media (max-width: 991.98px) {
    .navbar {
        background: #fff;
    }

    .navbar .navbar-brand, .navbar .nav-link {
        color: #555;
    }
}



/*
*
* ==========================================
* FOR DEMO PURPOSES
* ==========================================
*
*/
.text-small {
    font-size: 0.9rem !important;
}


body {

}
</style>
