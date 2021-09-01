<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid p-0 m-0 form-bg-color">
        <div class="container p-0">
            <div class="form">
                <div class="form-main">
                    <div class="container-fluid p-0 m-0">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-left">
                                    <div>
                                        <template v-if="!requestData">
                                            <div class="form-left-title">Заявка</div>
                                            <div class="form-left-description">Заполните форму чтобы стать членом Reserved</div>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Ваше имя</div>
                                                <input type="text" class="form-left-input-text" placeholder="Иван Иванов" v-model="user.name" :readonly="userStatus" ref="name">
                                            </div>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Ваш номер телефона</div>
                                                <input type="text" class="form-left-input-text" v-maska="'+7(###) ###-##-##'" placeholder="+7" v-model="user.phone" ref="phone" :readonly="userStatus">
                                            </div>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Название заведения</div>
                                                <input type="text" class="form-left-input-text" v-model="organization.name" ref="organization">
                                            </div>
                                            <div class="form-left-input-double">
                                                <div class="form-left-input form-left-input-split">
                                                    <div class="form-left-input-title">Тип заведения</div>
                                                    <select class="form-left-input-select" v-model="organization.category_id" ref="category">
                                                        <option v-for="(category,key) in categories" :key="key" :value="category.id" :selected="key === organization.category_id">{{category.title}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-left-input form-left-input-split">
                                                    <div class="form-left-input-title">Город</div>
                                                    <select class="form-left-input-select" v-model="organization.city_id" ref="city">
                                                        <option v-for="(city,key) in cities" :key="key" :value="city.id" :selected="key === organization.city_id">{{city.title}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-left-input-desc" onselectstart="return false">
                                                <input type="checkbox" id="scales" class="form-left-checkbox" v-model="checked">
                                                <label for="scales" class="form-left-label">Настоящим подтверждаю, что я ознакомлен и согласен с условиями политики конфиденциальности.</label>
                                            </div>
                                            <div class="form-left-input">
                                                <button class="form-left-button" :class="{'form-left-button-disabled':!checked}" @click="sendRequest()">Оставить заявку</button>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <template v-if="requestData.status === 'on'">
                                                <div class="form-left-title">Заявка отправлена</div>
                                                <div class="form-left-description">Ваша заявка на рассмотрении. В ближайшее время вы получите уведомление на ваш телефон номер.</div>
                                            </template>
                                            <template v-else>
                                                <div class="form-left-title">Заявка одобрена</div>
                                                <div class="form-left-description">На ваш телефон номер должно придти уведомление.</div>
                                            </template>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Ваше имя</div>
                                                <input type="text" class="form-left-input-text" :value="requestData.name" readonly>
                                            </div>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Ваш номер телефона</div>
                                                <input type="text" class="form-left-input-text" v-maska="'+7(###) ###-##-##'" placeholder="+7" :value="requestData.phone" readonly>
                                            </div>
                                            <div class="form-left-input">
                                                <div class="form-left-input-title">Название заведения</div>
                                                <input type="text" class="form-left-input-text" :value="requestData.organization_name" readonly>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="d-none d-md-block col-md-6">
                                <div class="form-right">
                                    <div class="form-right-wallpaper"></div>
                                    <div class="form-right-shadow"></div>
                                    <div class="form-right-content">
                                        <div class="form-icon"></div>
                                        <div class="form-icons">
                                            <div class="form-item"></div>
                                            <div class="form-item"></div>
                                            <div class="form-item"></div>
                                        </div>
                                        <div class="form-title">Станьте членом Reserved. Наш сервис упрощяет жизни миллионам людей. </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
    <notifications position="bottom left" classes="notification notification-error" :ignoreDuplicates="true"/>
</template>

<script>

import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import {maska} from 'maska';

export default {
    name: "Form",
    directives: { maska },
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
    },
    data() {
        return {
            categories: [],
            cities: [],
            userStatus: false,
            user: {
                name: '',
                phone: '',
            },
            organization: {
                name: '',
                category_id: 1,
                city_id: 1
            },
            checked: false,
            requestData: false
        }
    },
    created() {
        this.getUser();
        this.getOrganizations();
        this.getCities();
    },
    methods: {
        sendRequest: function() {
            if (this.user.name.trim() === '') {
                return this.$refs.name.focus();
            } else if (this.user.phone.trim() === '') {
                return this.$refs.phone.focus();
            } else if (this.organization.name.trim() === '') {
                return this.$refs.organization.focus();
            } else if (this.checked) {
                axios.post('/api/organizationRequest/create',{
                    name: this.user.name.trim(),
                    phone: this.user.phone.trim(),
                    organization_name: this.organization.name.trim(),
                    category_id: this.organization.category_id,
                    city_id: this.organization.city_id
                })
                    .then(response => {
                        this.requestData    =   response.data.data;
                    }).catch(error => {
                        this.$notify({
                            title: 'Произошла ошибка',
                            text: error.response.data.message,
                        });
                    });
            }
        },
        getUser: function () {
            if (this.storage.token && sessionStorage.user) {
                this.userStatus =   true;
                this.user = JSON.parse(sessionStorage.user);
                this.userCheck();
            }
        },
        userCheck: function() {
            axios.get('/api/organizationRequest/phone/'+this.user.phone)
            .then(response => {
                this.requestData    =   response.data.data;
            });
        },
        getOrganizations: function() {
            axios.get('/api/category/list')
                .then(response => {
                    this.categories =   response.data.data;
                });
        },
        getCities: function() {
            axios.get('/api/countries')
                .then(response => {
                    let data    =   response.data.data;
                    data.forEach(country => {
                        country.city_id.forEach(city => {
                            this.cities.push(city);
                        });
                    });
                });
        },

    }
}
</script>

<style lang="scss">
    .notification {
        background: #00a082;
        color: #fff;
        margin: 10px;
        border-radius: 5px;
        padding: 15px;
        box-shadow: 0 0 3px 1px rgba(0,0,0,.2);
        &-error {
            background: #FF8008;
        }
    }
    .form {
        min-height: 300px;
        &-title {
            text-align: center;
            margin: 30px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
        }
        &-item {
            width: 40px;
            height: 40px;
            background: #00a082 no-repeat center;
            box-shadow: 0 0 0 5px #fff;
            border-radius: 50px;
            background-size: 50%;
            margin: 0 auto 0 auto;
            &:first-child {
                background-image: url('/img/logo/restaurant.svg');
            }
            &:nth-child(2) {
                background-image: url('/img/logo/cafe.svg');
            }
            &:nth-child(3) {
                background-image: url('/img/logo/bar.svg');
            }
        }
        &-icons {
            width: 190px;
            display: flex;
            justify-content: space-between;
            margin: 40px auto 0 auto;
        }
        &-icon {
            background: url(/img/logo/reserved-logo.png) #fff no-repeat center;
            background-size: contain;
            width: 190px;
            height: 190px;
            margin: 20px auto 0 auto;
            box-shadow: 0 0 0 5px #fff;
            border-radius: 190px;
        }
        &-left {
            &-button {
                float: right;
                height: 40px;
                font-size: 14px;
                color: white;
                padding: 0 15px 0 15px;
                border-radius: 30px;
                border: none;
                background: #00a082;
                &-disabled {
                    opacity: .2;
                }
            }
            &-checkbox {
                margin: 4px 0 0 0;
            }
            &-label {
                margin: 0;
                cursor: pointer;
            }
            &-title {
                font-size: 40px;
                font-weight: bold;
                color: #000;
                margin: 50px 0 0 50px;
            }
            &-description {
                margin: 0 0 0 50px;
                font-size: 14px;
                color: grey;
            }
            &-input {
                margin: 15px 50px 0 50px;
                &-double {
                    display: flex;
                    gap: 20px;
                    margin: 15px 50px 0 50px;
                }
                &-title {
                    font-size: 12px;
                    color: grey;
                }
                &-text {
                    width: 100%;
                    height: 35px;
                    padding: 5px 0 5px 0;
                    font-size: 14px;
                    border: none;
                    border-bottom: 1px solid gainsboro;
                    outline: none;
                }
                &-split {
                    margin: 0;
                    flex-grow: 1;
                }
                &-desc {
                    margin: 15px 50px 0 50px;
                    font-size: 12px;
                    color: grey;
                    display: flex;
                    gap: 15px;
                }
                &-select {
                    border: none;
                    border-bottom: 1px solid gainsboro;
                    outline: none;
                    width: 100%;
                    height: 35px;
                    font-size: 14px;
                    background: transparent;
                    padding: 0 !important;
                    cursor: pointer;
                }
            }
        }
        &-right {
            height: 560px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            margin: 20px 20px 20px 0;
            border-radius: 5px;
            &-wallpaper {
                position: absolute;
                width: 110%;
                height: 110%;
                background: url(/img/main/img-15.jpg) no-repeat center;
                background-size: cover;
                filter: blur(5px);
                margin: -10px 0 0 -10px;
            }
            &-shadow {
                position: absolute;
                z-index: 1;
                width: 100%;
                height: 100%;
                background: #000;
                opacity: .8;
            }
            &-content {
                position: relative;
                z-index: 2;
            }
        }
        &-main {
            background: #fff;
            position: relative;
            top: -50px;
            z-index: 2;
            height: 600px;
            border-radius: 10px;
            box-shadow: 0 0 2px 0 rgba(0,0,0,.1);
            overflow: hidden;
        }
        &-bg {
            background: no-repeat center;
            background-size: cover;
            &-color {
                background: rgb(245,245,245);
            }
        }
    }
    @media only screen and (max-width: 768px) {
        .form {
            &-main {
                margin: 0 10px 0 10px;
                top: -15px;
                box-shadow: 0 0 3px 0 rgba(0,0,0,.2);
                border-radius: 8px;
                height: 430px;
            }
            &-left {
                &-button {
                    height: 30px;
                    font-size: 12px;
                    padding: 0 10px 0 10px;
                }
                &-title {
                    font-size: 24px;
                    margin: 30px 0 0 30px;
                }
                &-description {
                    margin: 0 0 0 30px;
                    font-size: 12px;
                    color: grey;
                }
                &-input {
                    margin: 10px 30px 0 30px;
                    &-title {
                        font-size: 11px;
                    }
                    &-text {
                        height: 30px;
                        font-size: 12px;
                    }
                    &-double {
                        gap: 15px;
                        margin: 10px 30px 0 30px;
                    }
                    &-select {
                        font-size: 12px;
                    }
                    &-desc {
                        margin: 10px 30px 0 30px;
                        font-size: 11px;
                    }
                    &-split {
                        margin: 0;
                    }
                }
            }
        }
    }
</style>
