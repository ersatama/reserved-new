<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid mb-5">
        <template v-if="!loading">
            <div class="container p-0">
                <div class="row">
                    <div class="col-12">
                        <h2 class="settings-title">Уведомления</h2>
                        <p class="settings-description text-secondary text-justify">
                            Здесь вы можете настроить Reserved-app во вашему устомтрению
                        </p>
                    </div>
                </div>
                <div class="row mt-2 mt-md-4">
                    <div class="col-12">
                        <ul class="list-group list-group-flush" onselectstart="return false;">
                            <li class="list-group-item px-0 d-flex justify-content-between settings-item align-items-center">
                                <div>
                                    <div class="h6 settings-list-title font-weight-bold">Язык</div>
                                    <p class="h6 settings-list-description text-secondary">Выберите желаемый язык.</p>
                                </div>
                                <div class="d-flex">
                                    <select class="form-control settings-select" aria-label="Default select example" v-if="languages.length > 0" @change="languageSelect($event)">
                                        <option disabled selected v-if="user.language_id === null">Не выбрано</option>
                                        <option :value="language.id" v-for="(language,key) in languages" :key="key" :selected="(user.language_id === language.id)">{{language.title}}</option>
                                    </select>
                                </div>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between settings-item align-content-center">
                                <div>
                                    <div class="h6 settings-list-title font-weight-bold">Push Уведомление</div>
                                    <p class="h6 settings-list-description text-secondary">Получать системные, маркетинговые уведомление</p>
                                </div>
                                <div class="settings-switcher">
                                    <div class="d-flex settings-form" :class="{'settings-form-active':(user.push_notification === 'on')}" @click="pushSwitcher()">
                                        <button class="btn btn-lg settings-btn border-0 shadow-sm"></button>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item px-0 d-flex justify-content-between settings-item align-content-center">
                                <div>
                                    <div class="h6 settings-list-title font-weight-bold">Email Уведомление</div>
                                    <p class="h6 settings-list-description text-secondary">Отправлять чеки на почту</p>
                                </div>
                                <div class="settings-switcher">
                                    <div class="d-flex settings-form" :class="{'settings-form-active':(user.email_notification === 'on')}" @click="emailSwitcher()">
                                        <button class="btn btn-lg settings-btn border-0 shadow-sm"></button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <loading></loading>
        </template>
    </div>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from "./sections/ProfileSection";
import Loading from './layout/Loading';
export default {
    name: "Settings",
    components: {
        Header,
        Footer,
        ProfileSection,
        Loading
    },
    data() {
        return {
            loading: true,
            user: false,
            languages: []
        }
    },
    created() {
        this.getUser();
        this.getLanguages();
    },
    methods: {
        getLanguages: function() {
            if (this.user) {
                axios.get('/api/languages/list')
                .then(response => {
                    this.languages  =   response.data.data;
                    this.loading    =   false;
                }).catch(error => {
                    this.loading    =   false;
                });
            }
        },
        getUser: function() {
            if (this.storage.token && sessionStorage.user) {
                this.user   =   JSON.parse(sessionStorage.user);
            } else {
                window.location.href = '/home';
            }
        },
        emailSwitcher: function() {
            if (this.user.email_notification) {
                if (this.user.email_notification === 'on') {
                    this.user.email_notification    =   'off';
                } else {
                    this.user.email_notification    =   'on';
                }
                this.updateUser();
            }
        },
        pushSwitcher: function() {
            if (this.user.push_notification) {
                if (this.user.push_notification === 'on') {
                    this.user.push_notification =   'off';
                } else {
                    this.user.push_notification =   'on';
                }
                this.updateUser();
            }
        },
        languageSelect: function(event) {
            this.user.language_id   =   parseInt(event.target.value);
            this.updateUser();
        },
        updateUser: function() {
            axios.post("/api/user/update/"+this.user.id, {
                language_id: this.user.language_id,
                email_notification: this.user.email_notification,
                push_notification: this.user.push_notification
            })
            .then(response => {
                let data    =   response.data;
                if (data.hasOwnProperty('data')) {
                    sessionStorage.user  =   JSON.stringify(data.data);
                    this.user   =   data.data;
                }
            });
        }
    }
}
</script>

<style lang="scss">
@import '../../css/profile/settings.scss';
</style>
