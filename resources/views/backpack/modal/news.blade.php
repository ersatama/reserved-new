<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<template v-if="showModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <template v-if="modalIndex === 0">
                        <div class="modal-header">
                            <slot name="header">
                                Добавить новость
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <template v-if="!addNews.imageAdd">
                                    <div class="modal-news-title">
                                        <input type="text" class="modal-news-title-input" ref="add_title" placeholder="Заголовок" v-model="addNews.title">
                                    </div>
                                    <div class="modal-news-body">
                                        <textarea col="5" class="modal-news-title-textarea" ref="add_description" placeholder="Описание" v-model="addNews.description"></textarea>
                                    </div>
                                    <div class="modal-news-images">
                                        <div class="modal-news-image" v-for="(image,key) in addNews.images" :key="key" :style="{'background-image': 'url('+image+')'}">
                                            <div class="modal-news-image-remove" @click="removeAddNewsImage(key)"></div>
                                        </div>
                                        <div class="modal-news-image" v-if="addNews.images.length !== 1" @click="$refs.file.click()">
                                            <div class="modal-news-image-add">Добавить фото</div>
                                        </div>
                                    </div>
                                    <input type="file" class="modal-hidden" ref="file" @change="loadImage($event)" accept="image/*">
                                </template>
                                <template v-else>
                                    <div class="modal-photo">
                                        <cropper
                                            ref="cropper"
                                            :src="addNews.img.src"
                                            @change="changeAdd"
                                        ></cropper>
                                    </div>
                                </template>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <template v-if="addNews.status">
                                    <template v-if="!addNews.imageAdd">
                                        <button class="modal-default-button" @click="readyAdd()">
                                            Готово
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button class="modal-additional-button" @click="addNews.imageAdd = false">
                                            Назад
                                        </button>
                                        <button class="modal-default-button" @click="readyImage">
                                            Добавить фотографию
                                        </button>
                                    </template>
                                </template>
                                <template v-else>
                                    <div class="meter animate">
                                        <span style="width: 100%"><span></span></span>
                                    </div>
                                </template>
                            </slot>
                        </div>
                    </template>
                    <template v-else-if="modalIndex === 1">
                        <div class="modal-header">
                            <slot name="header">
                                Редактирование
                            </slot>
                            <div class="modal-close" @click="showModal = false"></div>
                        </div>
                        <div class="modal-body">
                            <slot name="body">
                                <div class="modal-news-title">
                                    <input type="text" class="modal-news-title-input" ref="edit_title" placeholder="Заголовок" v-model="changeNews.title">
                                </div>
                                <div class="modal-news-body">
                                    <textarea col="5" class="modal-news-title-textarea" ref="edit_description" placeholder="Описание" v-model="changeNews.description"></textarea>
                                </div>
                            </slot>
                        </div>
                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" @click="saveEdit()">
                                    Сохранить
                                </button>
                            </slot>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </transition>
</template>
