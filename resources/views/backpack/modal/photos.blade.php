<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<template v-if="showModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <template v-if="modalIndex === 0">
                        <div class="modal-header">
                            <slot name="header">
                                Загрузка фотографий
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-photo">
                                    <cropper
                                        ref="cropper"
                                        :src="img.src"
                                        @change="change"
                                    ></cropper>
                                    <!--:stencil-props="{
                                         aspectRatio: 1/1,
                                     }"-->
                                </div>
                            </slot>
                        </div>
                        <input type="file" class="modal-hidden" ref="file" @change="loadImage($event)" accept="image/*">
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-additional-button" @click="$refs.file.click()">
                                    Выбрать фотографию
                                </button>
                                <button class="modal-default-button" @click="uploadImage()">
                                    Готово
                                </button>
                            </slot>
                        </div>
                    </template>
                    <template v-else-if="modalIndex === 1">
                        <div class="modal-header">
                            <slot name="header">
                                Просмотр фотографий
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-photo-view">
                                    <img :src="photos[imageIndex].image" width="100%">
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="deleteImage()">
                                    Удалить
                                </button>
                            </slot>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </transition>
</template>
