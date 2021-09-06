<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid mb-5">
        <div class="container p-0">
            <template v-if="user">
                <div class="row">
                    <div class="col-12">
                        <h2 class="profile-title">Личная информация</h2>
                        <p class="profile-description text-secondary text-justify">
                            Ваши контактные данные
                        </p>
                    </div>
                </div>
                <div class="row mt-md-5 justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="form-group row profile-row">
                            <label for="name" class="col-sm-4 col-form-label font-weight-bold profile-title-input">Имя</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control profile-input" id="name" ref="name" v-model="name" v-on:keyup.enter="saveUser">
                            </div>
                        </div>
                        <div class="form-group row profile-row">
                            <label for="phone" class="col-sm-4 col-form-label font-weight-bold profile-title-input">Телефон</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control profile-input" id="phone" ref="phone" :value="user.phone" readonly>
                            </div>
                        </div>
                        <div class="form-group row profile-row">
                            <label for="email" class="col-sm-4 col-form-label font-weight-bold profile-title-input">Эл.почта</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control profile-input" id="email" ref="email" v-model="email" v-on:keyup.enter="saveUser">
                            </div>
                        </div>
                        <div class="form-group row profile-row" v-if="saveError">
                            <div class="col">
                                <p class="profile-error text-right">Эл.почта уже занята</p>
                            </div>
                        </div>
                        <div class="form-group row profile-row" v-if="saveSuccess">
                            <div class="col">
                                <p class="profile-success text-right">Изменения сохранены, обновите страницу</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col d-flex justify-content-center mt-3">
                                <button class="btn profile-btn text-white" @click="saveUser">
                                    <span v-if="save">Сохранить изменения</span>
                                    <div class="loading-btn" v-else>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h2 class="profile-title">Пароль</h2>
                        <p class="profile-description text-secondary text-justify">
                            Здесь вы можете сменить ваш пароль
                        </p>
                    </div>
                </div>
                <div class="row mt-md-5 justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="form-group row profile-row">
                            <label for="old" class="col-sm-4 col-form-label font-weight-bold profile-title-input">Старый пароль</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control profile-input" id="old" v-model="oldPass" ref="oldPass">
                            </div>
                        </div>
                        <div class="form-group profile-row row">
                            <label for="new" class="col-sm-4 col-form-label font-weight-bold profile-title-input">Новый пароль</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control profile-input" id="new" v-model="newPass" ref="newPass">
                            </div>
                        </div>
                        <div class="form-group row profile-row" v-if="passSaveError">
                            <div class="col">
                                <p class="profile-error text-right">{{passSaveErrorMessage}}</p>
                            </div>
                        </div>
                        <div class="form-group row profile-row" v-if="passSaveSuccess">
                            <div class="col">
                                <p class="profile-success text-right">{{passSaveSuccessMessage}}</p>
                            </div>
                        </div>
                        <div class="row profile-row">
                            <div class="col d-flex justify-content-center mt-3">
                                <button type="submit" class="btn profile-btn text-white" @click="passChange">
                                    <span v-if="passSave">Сохранить изменения</span>
                                    <div class="loading-btn" v-else>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu
    },
    name: "Profile",
    data() {
        return {
            user: false,
            save: true,
            saveSuccess: false,
            saveError: false,
            name: '',
            email: '',
            passSave: true,
            passSaveSuccess: false,
            passSaveSuccessMessage: '',
            passSaveError: false,
            passSaveErrorMessage: '',
            oldPass: '',
            newPass: '',
        }
    },
    created() {
        this.getUser();
    },
    methods: {
        passChange: function() {
            if (this.passSave) {
                if (this.oldPass !== null && this.oldPass.trim().length === 0) {
                    return this.$refs.oldPass.focus();
                } else if (this.newPass !== null && this.newPass.trim().length < 8) {
                    return this.$refs.newPass.focus();
                }
                this.passSave   =   false;
                this.passSaveError  =   false;
                this.passSaveSuccess    =   false;
                axios.post("/api/user/password/"+this.user.id, {
                    old: this.oldPass.trim(),
                    new: this.newPass.trim()
                })
                    .then(response => {
                        let data    =   response.data;
                        this.passSaveSuccessMessage =   data.message;
                        this.passSave   =   true;
                        this.passSaveSuccess    =   true;
                        this.newPass    =   '';
                        this.oldPass    =   '';
                    }).catch(error => {
                        this.passSaveErrorMessage   =   error.response.data.message
                        this.passSave   =   true;
                        this.passSaveError  =   true;
                    });
            }
        },
        saveUser: function() {
            if (this.save) {
                if (this.name !== null && this.name.trim().length < 1) {
                    return this.$refs.name.focus();
                } else if (this.email !== null && this.email !== '' && !this.validateEmail(this.email)) {
                    return this.$refs.email.focus();
                }
                this.save   =   false;
                this.saveError  =   false;
                this.saveSuccess    =   false;
                axios.post("/api/user/update/"+this.user.id, {
                    name: this.name.trim(),
                    email: this.email
                })
                .then(response => {
                    let data    =   response.data;
                    if (data.hasOwnProperty('data')) {
                        sessionStorage.user  =   JSON.stringify(data.data);
                        this.user   =   data.data;
                    }
                    this.save   =   true;
                    this.saveSuccess    =   true;
                }).catch(error => {
                    this.save   =   true;
                    this.saveError  =   true;
                });
            }
        },
        validateEmail: function(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        getUser: function () {
            if (this.storage.token && sessionStorage.user) {
                this.user = JSON.parse(sessionStorage.user);
                this.setUser();
            } else {
                window.location.href = '/home';
            }
        },
        setUser: function() {
            let user    =   JSON.parse(sessionStorage.user);
            this.name   =   user.name;
            this.email  =   user.email;
        }
    }
}
</script>

<style lang="scss">
    @import '../../css/profile/profile.scss';

    .top {
        &-bg {
            background: #fff;
        }
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link {
        border: 1px solid transparent !important;
        font-size: 12px;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        background: whitesmoke !important;
        border: 1px solid #e6f1ec !important;
        border-bottom-color: transparent !important;
    }
</style>
