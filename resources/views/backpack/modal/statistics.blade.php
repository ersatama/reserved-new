<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<template v-if="showModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                            Фильтр
                        </slot>
                        <div class="modal-close" @click="showModal = false"></div>
                    </div>
                    <div class="modal-body" data-provide="datepicker-inline">
                        <slot name="body">
                            <v-date-picker mode='date' is-range v-model='selectedDate' columns="1" class="modal-calendar" show-caps color="green"></v-date-picker>
                        </slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button" @click="readyFilter()">
                                Готово
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
