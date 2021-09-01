<template>
    <div class="container-fluid pb-3 pb-md-5 organization-bg">
        <div class="container">
            <div class="row pt-4">
                <div class="col-12">
                    <Loading v-if="status"></Loading>
                    <div class="row justify-content-center" v-else-if="images.length > 0">
                        <div class="col-3 p-2" v-for="(image,imageKey) in images || []" :key="imageKey">
                            <div class="organization-image" :style="{'background-image':'url('+image.image+')'}" @click="showImg(imageKey)">
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <NotFound v-else :params="empty"></NotFound>
                    <vue-easy-lightbox scrollDisabled escDisabled moveDisabled :visible="img.visible" :imgs="img.list" :index="img.index" @hide="handleHide">
                        <template v-slot:toolbar="{ toolbarMethods }">
                        </template>
                    </vue-easy-lightbox>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../layout/Loading';
import NotFound from '../layout/Not-found';
import VueEasyLightbox from 'vue-easy-lightbox';
export default {
    props: ['api'],
    name: "Photos",
    components: {
        Loading,
        NotFound,
        VueEasyLightbox
    },
    data() {
        return {
            toolbarMethods: {
                loop: true,
                moveDisabled: true,
            },
            empty: {
                img: '/img/logo/no-photo.svg',
                title: 'Пусто',
                description: 'Фотографии не найдено'
            },
            img: {
                visible: false,
                index: 0,
                list: [],
            },
            status: true,
            images: [],
        }
    },
    mounted() {
        this.getImages();
    },
    methods: {
        showImg: function(index) {
            this.img.index = index
            this.img.visible = true
        },
        handleHide: function() {
            this.img.visible    =   false
        },
        getImages: function() {
            axios.get(this.api)
                .then(response => {
                    this.images =   response.data.data;
                    this.images.forEach(image => {
                        this.img.list.push(image.image);
                    });
                    this.status     =   false;
                }).catch(error => {
                    this.status     =   false;
                });
        }
    }
}
</script>

<style scoped>

</style>
