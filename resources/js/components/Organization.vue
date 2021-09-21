<template>
    <Header></Header>
    <profile-section :name="organization.title || ''" :id="$route.params.id" :category="category"></profile-section>
    <loading v-if="loading"></loading>
    <template v-else-if="organization">
        <div class="container-fluid bg-white">
            <div class="row">
                <div class="wallpaper" :style="{'background-image':'url('+organization.wallpaper+')'}">
                    <div class="wallpaper-screen">
                        <div class="organization-description text-center text-white">{{organization.address}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-white">
            <div class="container p-0">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="organization-main">
                            <div class="d-flex organization-photo">
                                <div class="organization-logo">
                                    <img v-if="organization.image" :src="organization.image">
                                </div>
                            </div>
                            <div class="organization-title text-dark font-weight-bold text-center">
                                <div>{{organization.title}}</div>
                                <div class="favorite-main" :class="{'favorite-main-off':(!storage.favorite.includes(organization.id)),'favorite-main-on':(storage.favorite.includes(organization.id))}" @click="favorite(organization.id)"></div>
                            </div>
                            <div class="organization-rating">
                                <div>
                                    <div class="organization-rating-star" :class="{'organization-rating-star-sel':(organization.rating >= 0.5)}"></div>
                                    <div class="organization-rating-star" :class="{'organization-rating-star-sel':(organization.rating >= 1.5)}"></div>
                                    <div class="organization-rating-star" :class="{'organization-rating-star-sel':(organization.rating >= 2.5)}"></div>
                                    <div class="organization-rating-star" :class="{'organization-rating-star-sel':(organization.rating >= 3.5)}"></div>
                                    <div class="organization-rating-star" :class="{'organization-rating-star-sel':(organization.rating >= 4.5)}"></div>
                                    <div class="organization-rating-count" v-if="organization.rating">{{organization.rating}}</div>
                                </div>
                            </div>
                            <div class="wallpaper-icons">
                                <a :href="organization.vk" v-show="organization.vk" target="_blank" class="wallpaper-icon wallpaper-icon-vk"></a>
                                <a :href="organization.youtube" v-show="organization.youtube" target="_blank" class="wallpaper-icon wallpaper-icon-youtube"></a>
                                <a :href="organization.facebook" v-show="organization.facebook" target="_blank" class="wallpaper-icon wallpaper-icon-facebook"></a>
                                <a :href="organization.instagram" v-show="organization.instagram" target="_blank" class="wallpaper-icon wallpaper-icon-instagram"></a>
                            </div>
                            <template v-if="user">
                                <div class="organization-subscribed" v-if="subscribe && subscribe.status === 'on'" @click="subscribeNow()">Вы подписаны</div>
                                <div class="organization-subscribe" v-else @click="subscribeNow()">Подписаться</div>
                            </template>
                            <div v-else class="organization-subscribe" data-toggle="modal" data-target="#auth_modal">Подписаться</div>
                        </div>
                        <div class="organization-description text-secondary text-center">{{organization.description}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-white organization-shadow-main px-0">
            <div class="container py-0">
                <div class="row pt-2">
                    <div class="col d-flex justify-content-center">
                        <div class="card text-center bg-transparent border-0">
                            <div class="card-header bg-transparent d-flex justify-content-center border-0">
                                <ul class="nav nav-tabs card-header-tabs margin-0 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link h6 text-secondary bg-transparent organization-tab py-3 px-0 d-block" :class="{active: (tab === 1), 'organization-tab-sel': (tab === 1)}" role="button" @click="tab = 1">Бронирование</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link h6 text-secondary bg-transparent organization-tab py-3 px-0 d-block" :class="{active: (tab === 2), 'organization-tab-sel': (tab === 2)}" role="button" @click="tab = 2">Галлерея</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link h6 text-secondary bg-transparent organization-tab py-3 px-0 d-block" :class="{active: (tab === 3), 'organization-tab-sel': (tab === 3)}" role="button" @click="tab = 3">Отзывы</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link h6 text-secondary bg-transparent organization-tab py-3 px-0 d-block" :class="{active: (tab === 4), 'organization-tab-sel': (tab === 4)}" role="button" @click="tab = 4">Меню</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Sections v-if="tab === 1" :id="organization.id" :organization="organization"></Sections>
        <Photos v-if="tab === 2" :api="'/api/image/organization/'+organization.id"></Photos>
        <Reviews v-if="tab === 3" :id="organization.id"></Reviews>
        <Photos v-if="tab === 4" :api="'/api/menu/list/'+organization.id"></Photos>
    </template>
    <not-found v-else :params="notFound"></not-found>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import NotFound from './layout/Not-found'
import Loading from './layout/Loading';
import Reviews from './layout/Reviews';
import Photos from './layout/Photos';
import Sections from './layout/Sections';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        NotFound,
        Loading,
        Reviews,
        Photos,
        Sections
    },
    name: "Organization",
    data() {
        return {
            category: false,
            notFound: {
                img: '/img/logo/table.svg',
                title: 'Заведение не найдено',
                description: 'Возможно в данный момент заведение закрыт'
            },
            loading: true,
            status: 0,
            tab: 1,
            organization: false,
            subscribe: false,
            user: false
        }
    },
    created() {
        this.setUser();
        this.getCategoryBySlug();
    },
    methods: {
        subscribeNow: function() {
            if (!this.subscribe) {
                axios.post('/api/newsSubscribe/create',{
                    organization_id: this.organization.id,
                    user_id: this.user.id
                }).then(response => {
                    this.subscribe  =   response.data.data;
                });
            } else if (this.subscribe.status === 'on') {
                this.subscribe.status   =   'off';
                axios.post('/api/newsSubscribe/update/'+this.subscribe.id,{
                    organization_id: this.organization.id,
                    user_id: this.user.id,
                    status: 'off'
                });
            } else {
                this.subscribe.status   =   'on';
                axios.post('/api/newsSubscribe/update/'+this.subscribe.id,{
                    organization_id: this.organization.id,
                    user_id: this.user.id,
                    status: 'on'
                });
            }
        },
        setUser: async function () {
            if (this.storage.token) {
                let user    =   JSON.parse(sessionStorage.getItem('user'));
                if (user) {
                    this.status = true;
                    this.user = user;
                } else {
                    await axios.get('/api/token/' + this.storage.token)
                        .then(response => {
                            let data = response.data;
                            if (data.hasOwnProperty('data')) {
                                sessionStorage.user = JSON.stringify(data.data);
                                this.status = true;
                                this.user = JSON.parse(sessionStorage.user);
                            }
                        }).catch(error => {
                            this.status = false;
                        });
                }
            }
        },
        getCategoryBySlug: function() {
            axios.get('/api/category/slug/'+this.$route.params.category)
                .then(response => {
                    this.category   =   response.data.data;
                    this.getOrganization();
                });
        },
        favorite: function(id) {
            let len =   this.storage.favorite.length;
            let status  =   true;
            for (let i = 0; i < len; i++) {
                if (this.storage.favorite[i] === id) {
                    this.storage.favorite.splice(i,1);
                    status  =   false;
                }
            }
            if (status) {
                this.storage.favorite.push(id);
            }
        },
        getOrganization: function() {
            axios.get('/api/organization/'+this.$route.params.id)
                .then(response => {
                    this.organization   =   response.data.data;
                    this.loading    =   false;
                    this.getSubscribe();
                }).catch(error => {
                    this.loading    =   false;
                });
        },
        getSubscribe: function() {
            if (this.user) {
                axios.get('/api/newsSubscribe/getByOrganizationIdAndUserId/'+this.organization.id+'/'+this.user.id)
                    .then(response => {
                        this.subscribe  =   response.data.data;
                    }).catch(error => {
                        this.subscribe  =   false;
                    });
            }
        }
    }
}
</script>

<style lang="scss">
    @import '../../css/favorite/favorite.scss';
    @import '../../css/organization/organization.scss';
</style>
