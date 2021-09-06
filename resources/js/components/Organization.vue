<template>
    <Header></Header>
    <profile-section :name="organization.title || ''" :id="$route.params.id" :category="category"></profile-section>
    <loading v-if="loading"></loading>
    <template v-else-if="organization">
        <div class="container-fluid bg-white">
            <div class="container p-0">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="wallpaper">
                            <div class="wallpaper-screen">
                                <div class="organization-description text-center text-white">{{organization.address}}</div>
                                <div class="organization-description text-center text-white"></div>
                            </div>
                            <img v-if="organization.wallpaper" :src="organization.wallpaper">
                        </div>
                        <div class="d-flex justify-content-center organization-photo">
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
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
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
        FooterMenu,
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
        }
    },
    created() {
        this.getCategoryBySlug();
        this.getOrganization();
    },
    methods: {
        getCategoryBySlug: function() {
            axios.get('/api/category/slug/'+this.$route.params.category)
                .then(response => {
                    this.category   =   response.data.data;
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
                }).catch(error => {
                    this.loading    =   false;
                });
        },
    }
}
</script>

<style lang="scss">
    @import '../../css/favorite/favorite.scss';
    @import '../../css/organization/organization.scss';
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {

    }
</style>
