<template>
    <div class="modal fade" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="booking_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <div class="modal-body" onselectstart="return false">
                    <div class="form-group d-flex justify-content-end">
                        <button class="auth-btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="form-group">
                        <h3 class="auth-title text-center">Бронирование стола</h3>
                        <h6 class="text-secondary text-center mt-3"  v-if="table">{{table.title}}</h6>
                    </div>
                    <template v-if="table && table.status === 'ENABLED' && (table.bookingStatus === null || table.bookingStatus.status === 'COMPLETED')">
                        <template v-if="status">
                            <template v-if="!storage.modal">
                                <template v-if="date.time.length > 0">
                                    <div class="col-12 mt-3">
                                        <div class="form-group booking-time">
                                            <div class="booking-time-item" v-for="(time,key) in date.time" :class="{'booking-time-item-sel':(key === date.timeIndex)}" :key="key" @click="date.timeIndex = key">{{time.time}}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2">
                                        <button class="btn btn-block auth-register text-white" @click="storageModal(true)">Далее</button>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-12 mt-3">
                                        <div class="form-group d-flex justify-content-center p-0">
                                            <img src="/img/logo/oops.svg" width="100">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="h6 text-center text-secondary font-weight-bold">Извините! На сегодня нельзя забронировать стол в этом заведении. Но вы можете выбрать другое заведение или другую дату.</div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2">
                                        <button class="btn btn-block auth-register text-white" data-dismiss="modal" aria-label="Close">Ок, понятно</button>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <template v-if="cards.length > 0">
                                    <div class="form-group mx-3 booking-card-list" v-if="cardError">
                                        <h5 class="text-danger text-center">Произошла ошибка, попробуите заново!</h5>
                                    </div>
                                    <div class="form-group mx-3 booking-card-list">
                                        <div class="booking-card" :class="{'booking-card-sel':(key === cardIndex)}" v-for="(item,key) in cards" :key="key" @click="cardIndex = key">
                                            <div class="booking-card-icon"></div>
                                            <div class="booking-card-detail">
                                                <div class="booking-card-detail-title">{{item.bank}}</div>
                                                <div class="booking-card-detail-num">{{item.hash}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="booking-empty mt-3">
                                        <div class="booking-empty-icon"></div>
                                        <div class="booking-empty-title">У вас нет карт</div>
                                    </div>
                                </template>
                                <div class="col-12 mt-2 mt-md-4">
                                    <button class="btn btn-block bg-light text-dark" @click="bookingAddCard()" style="border-radius: 30px; height: 44px;">
                                        <div v-if="!cardLoading">Добавить карту карту</div>
                                        <div class="spinner" v-else></div>
                                    </button>
                                </div>
                                <div class="col-12 mt-2 mt-md-4">
                                    <button class="btn btn-block auth-register text-white" @click="bookingAuthFinish()" :disabled="cards.length === 0">Оплатить {{this.table.price}} KZT</button>
                                </div>
                                <div class="col-12 mt-2 mt-md-4 mb-2">
                                    <button class="btn btn-block auth-register text-white" @click="storage.modal = false">Назад</button>
                                </div>
                            </template>
                        </template>
                        <template v-else>
                            <template v-if="!storage.modal">
                                <template v-if="date.time.length > 0">
                                    <div class="col-12 mt-3">
                                        <div class="form-group booking-time">
                                            <div class="booking-time-item" v-for="(time,key) in date.time" :class="{'booking-time-item-sel':(key === date.timeIndex)}" :key="key" @click="date.timeIndex = key">{{time.time}}</div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2">
                                        <button class="btn btn-block auth-register text-white" @click="storage.modal = true">Далее</button>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="col-12 mt-3">
                                        <div class="form-group d-flex justify-content-center p-0">
                                            <img src="/img/logo/oops.svg" width="100">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="h6 text-center text-secondary font-weight-bold">Извините! На сегодня нельзя забронировать стол в этом заведении. Но вы можете выбрать другое заведение или другую дату.</div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2">
                                        <button class="btn btn-block auth-register text-white" data-dismiss="modal" aria-label="Close">Ок, понятно</button>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <template v-if="!guest.verify">
                                    <div class="col-12 mt-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control p-3 auth-input" placeholder="Ваше имя" v-model="guest.name" ref="guest_name" v-on:keyup.enter="guestAuth">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="form-group">
                                            <div class="auth-phone-prefix">+7</div>
                                            <input type="number" class="form-control p-3 auth-input auth-phone" v-maska="'##########'" v-model="guest.phone" ref="guest_phone" v-on:keyup.enter="guestAuth">
                                        </div>
                                    </div>
                                    <div class="col-12 mt-4 mb-2 d-flex" style="gap: 20px;">
                                        <div class="w-50">
                                            <button class="btn btn-block auth-btn text-white" @click="storage.modal = false">Назад</button>
                                        </div>
                                        <div class=" w-50">
                                            <button class="btn btn-block auth-register text-white" @click="guestAuth">Далее</button>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="form-group">
                                        <h6 class="text-secondary text-center mt-3">На Ваш номер был отправлен код</h6>
                                    </div>
                                    <div class="form-group p-0" v-if="guest.codeError">
                                        <div class="auth-error font-weight-bold text-center">Не код правильный код подтверждения.</div>
                                    </div>
                                    <div class="form-row mx-3">
                                        <div class="col-12 mt-3">
                                            <input type="number" class="form-control p-3 auth-input" v-maska="'######'" v-model="guest.code" placeholder="код смс" ref="sms_code">
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button class="btn btn-block auth-btn text-white" @click="bookingGuest()">
                                                <div v-if="!guest.codeCheck">Подтвердить<span v-if="getPrice() > 0"> и оплатить {{getPrice()}} KZT</span></div>
                                                <div class="spinner" v-else></div>
                                            </button>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button class="btn btn-block auth-register text-white" @click="guest.verify = false" v-if="!guest.codeCheck">Отмена</button>
                                            <button class="btn btn-block auth-register text-white" v-else disabled>Отмена</button>
                                        </div>
                                    </div>
                                </template>
                                <div class="col-12 mt-4">
                                    <p class="text-secondary auth-txt text-center">На сайте применяются Политика Конфиденциальности и Условия Пользования </p>
                                </div>
                            </template>
                        </template>
                    </template>
                    <template v-else>
                        <div class="col-12 mt-3">
                            <div class="form-group d-flex justify-content-center p-0">
                                <img src="/img/logo/oops.svg" width="100">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="h6 text-center text-secondary font-weight-bold">Извините, этот стол уже забронирован. Попробуите выбрать другой стол или другую дату.</div>
                        </div>
                        <div class="col-12 mt-4 mb-2">
                            <button class="btn btn-block auth-register text-white" data-dismiss="modal" aria-label="Close">Ок, понятно</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { maska } from 'maska'
export default {
    directives: { maska },
    name: "Booking",
    props: ['organization','table','date'],
    data() {
        return {
            lang: 'ru',
            status: false,
            user: false,
            cardStatus: true,
            cardError: false,
            cardLoading: false,
            cardIndex: 0,
            cards: [],
            authUser: {
                status: true,
                next: false,
                card: '',
            },
            guest: {
                status: true,
                next: false,
                verify: false,
                name: '',
                phone: '',
                code: '',
                codeCheck: false,
                codeError: false,
                user: {
                    api_token: ''
                }
            }
        }
    },
    created() {
        this.setUser();
        this.setTime();
    },
    mounted() {
        if (this.user) {
            window.Echo.private('new.card.'+this.user.id)
                .listen('.new.card', (e) => {
                    this.cardUpdate(e);
                });
        }
    },
    methods: {
        getPrice: function() {
            if (this.table.price > 0) {
                return this.table.price;
            }
            return 0;
        },
        storageModal: function(status) {
            if (parseInt(this.table.price) === 0) {
                this.bookingAuthFinish();
            } else {
                this.storage.modal = true;
            }
        },
        setTime: function() {
            let today   =   new Date();
            today       =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
            let current =   this.date.data.split('-');
            current     =   new Date(current[0],(current[1] - 1),current[2]);
            if (today.getTime() === current.getTime()) {

            }
        },
        bookingGuest: function() {
            if (!this.guest.codeCheck) {
                if (this.guest.code.trim().length !== 6) {
                    return this.$refs.sms_code.focus();
                }
                this.guest.codeCheck    =   true;
                this.guest.codeError    =   false;
                axios.post("/api/booking/guest", {
                    user_id: this.guest.user.id,
                    title: this.organization.title,
                    organization_id: this.organization.id,
                    organization_table_list_id: this.table.id,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    time: this.date.time[ this.date.timeIndex ].time,
                    date: this.date.data,
                    price: this.getPrice(),
                    code: this.guest.code,
                })
                .then(response => {
                    let data = response.data.data;
                    this.storage.token  =   this.guest.user.api_token;
                    sessionStorage.user =   JSON.stringify(this.guest.user);
                    if (this.getPrice() > 0) {
                        window.location.href    =   data.payment;
                    } else {
                        window.location.href    =   '/profile/history';
                    }
                }).catch(error => {
                    this.guest.codeCheck    =   false;
                    this.guest.codeError    =   true;
                });
            }
        },
        guestAuth: function() {
            if (String(this.guest.name).length < 2) {
                return this.$refs.guest_name.focus();
            } else if (String(this.guest.phone).length !== 10) {
                return this.$refs.guest_phone.focus();
            }

            axios.post("/api/user/new", {
                name: this.guest.name,
                phone: '7'+this.guest.phone
            })
            .then(response => {
                this.guest.user     =   response.data;
                this.guest.verify   =   true;
                this.guest.codeError    =   false;
            }).catch(error => {
                console.error(error.response);
            });
        },
        bookingAddCard: function() {
            if (!this.cardLoading) {
                this.cardLoading    =   true;
                this.cardStatus     =   false;
                axios.post('/api/booking/card/', {
                    user_id: this.user.id,
                    organization_id: this.organization.id,
                    organization_table_list_id: this.table.id,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    time: this.date.time[ this.date.timeIndex ].time,
                    date: this.date.data,
                    price: this.getPrice(),
                })
                    .then(response => {
                        window.location.href    =   response.data;
                        this.cardLoading    =   false;
                    }).catch(error => {
                        this.cardStatus     =   true;
                        this.cardLoading    =   false;
                    });
            }
        },
        bookingAuthFinish: function() {
            if (this.cardStatus) {
                this.cardStatus =   false;
                this.cardError  =   false;
                axios.post("/api/booking/create", {
                    user_id: this.user.id,
                    organization_id: this.organization.id,
                    organization_table_list_id: this.table.id,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
                    time: this.date.time[ this.date.timeIndex ].time,
                    date: this.date.data,
                    price: this.getPrice(),
                    card_id: this.getPrice()>0?this.cards[ this.cardIndex ].card_id:0
                })
                .then(response => {
                    let data = response.data.data;
                    if (this.getPrice() > 0) {
                        window.location.href    =   '/form/'+data.id;
                    } else {
                        window.location.href    =   '/profile/history';
                    }

                }).catch(error => {
                    console.log('error', error.response);
                    this.cardStatus =   true;
                    this.cardError  =   true;
                });
            }
        },
        setUser: async function () {
            if (this.storage.token) {
                let user    =   JSON.parse(sessionStorage.getItem('user'));
                if (user) {
                    this.status = true;
                    this.user = user;
                    this.cardList();
                } else {
                    await axios.get('/api/token/' + this.storage.token)
                        .then(response => {
                            let data = response.data;
                            if (data.hasOwnProperty('data')) {
                                sessionStorage.user = JSON.stringify(data.data);
                                this.status = true;
                                this.user = JSON.parse(sessionStorage.user);
                                this.cardList();
                            }
                        }).catch(error => {
                            this.status = false;
                        });
                }

            }
        },
        cardList: function() {
            axios.get('/api/card/user/'+this.user.id)
            .then(response => {
                this.cards  =   response.data.data;
            }).catch(error => {
                console.log(error.response.data);
            });
        },
        cardUpdate: function(data) {
            if (data !== undefined) {
                this.cards.push(data.card);
            }
        },
    }
}
</script>

<style lang="scss">
.booking {
    &-empty {
        display: grid;
        grid-gap: 15px;
        &-icon {
            width: 70px;
            height: 70px;
            background: url('/img/logo/card.svg') no-repeat center;
            background-size: cover;
            margin: 0 auto 0 auto;
        }
        &-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            color: darkgrey;
        }
    }
    &-card {
        display: grid;
        grid-template-columns: 40px auto;
        grid-gap: 15px;
        background: rgb(250,250,250);
        border-radius: 10px;
        padding: 10px 15px 10px 15px;
        cursor: pointer;
        color: grey;
        &:hover, &-sel {
            background: #FF8008;
            color: #fff;
        }
        &-list {
            display: grid;
            gap: 15px;
        }
        &-icon {
            width: 40px;
            background: url('/img/logo/card.svg') no-repeat center;
            background-size: contain;
        }
        &-detail {
            &-title {
                font-size: 18px;
                font-weight: bold;
            }
            &-num {
                font-size: 12px;
            }
        }
    }

    &-time {
        display: grid;
        grid-template-columns: repeat(5,auto);
        gap: 10px;
        &-item {
            float: left;
            padding: 10px 0 10px 0;
            border-right: 30px;
            background: rgb(250,250,250);
            text-align: center;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            &:hover, &-sel {
                background: #00a082;
                color: #fff;
            }
        }
    }
    &-input {
        color: #00a082;
        outline: none !important;
        font-size: 20px;
        background: transparent;
    }
}
a {
    text-decoration: none;
    display: inline-block;
    padding: 8px 16px;
}

.round {
    border-radius: 50%;
}
@media only screen and (max-width: 768px) {
    .booking {
        &-time {
            &-item {
                padding: 8px 0 8px 0;
                font-size: 12px;
            }
        }
        &-empty {
            &-title {
                font-size: 12px;
            }
        }
    }
}
</style>
