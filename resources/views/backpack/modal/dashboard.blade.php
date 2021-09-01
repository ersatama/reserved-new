<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<template v-if="showModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                            Бронирование
                        </slot>
                        <div class="modal-close" @click="showModal = false"></div>
                    </div>
                    <div class="modal-body" data-provide="datepicker-inline">
                        <slot name="body">
                            <div class="modal-inputs">
                                <div class="modal-input w-100">
                                    <div class="modal-table">
                                        <div class="modal-table-title">@{{ booking.table.title }}</div>
                                        <div class="modal-table-price">@{{ booking.table.limit }} человек</div>
                                        <div class="modal-table-price" v-if="booking.table.price > 0">@{{ booking.table.price }} KZT</div>
                                        <div class="modal-table-price" v-else>Без депозита</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-inputs">
                                <div class="modal-input">
                                    <div class="font-weight-bold">Время</div>
                                    <input type="text" class="modal-text" v-mask="'##:##'" v-model="booking.time" ref="time" placeholder="00:00" minlength="5" maxlength="5" pattern="[0-9]*" inputmode="numeric">
                                </div>
                                <div class="modal-input">
                                    <div class="font-weight-bold">Номер телефона</div>
                                    <input type="text" class="modal-text" v-model="booking.phone" v-mask="'+7 (###) ###-##-##'" @blur="phoneCheck()" ref="phone" pattern="[0-9]*" inputmode="numeric">
                                    <div class="font-weight-bold">Имя</div>
                                    <input type="text" class="modal-text" v-model="booking.name" ref="name">
                                    <button class="modal-default-button" @click="newBooking()">
                                        Готово
                                    </button>
                                </div>
                            </div>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
