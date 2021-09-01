<template>
    <Header></Header>
    <profile-section></profile-section>
    <loading v-if="Loading"></loading>
    <div class="container-fluid p-0 m-0 home-bg-color" v-else-if="menu.length">
        <div class="container p-0">
            <div class="row home-main">
                <div class="col-12 col-md-6 d-flex justify-content-center p-0" v-for="(item,key) in menu" :key="key">
                    <a :href="'/home/'+item.slug" class="d-block w-100 text-decoration-none p-2">
                        <div class="home-category">
                            <div class="home-category-shadow">
                                <div class="home-category-shadow-layer">
                                    <div class="home-category-icon">
                                        <div :style="{'background-image': 'url('+item.image+')'}"></div>
                                    </div>
                                    <div>
                                        <div class="home-category-title">
                                            {{item.title}}
                                        </div>
                                        <div class="home-category-description">
                                            {{item.description}}
                                        </div>
                                    </div>
                                    <div class="home-category-arrow">
                                        <div></div>
                                    </div>
                                </div>
                                <div class="home-category-shadow-img home-bg" :style="{'background-image':'url('+item.wallpaper+')'}"></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <not-found v-else :params="notFound"></not-found>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import NotFound from './layout/Not-found';
import Loading from './layout/Loading';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
        NotFound,
        Loading
    },
    name: "Home",
    data() {
        return {
            menu: [],
            Loading: true,
            notFound: {
                img: '/img/logo/menu.svg',
                title: 'Список пуст',
                description: 'Здесь будет отображаться Категории.'
            }
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories: function() {
            axios.get('/api/category/list')
                .then(response => {
                    this.Loading    =   false;
                    this.menu       =   response.data.data;
                }).catch(error => {
                    this.Loading    =   false;
                });
        }
    }
}
</script>

<style lang="scss">
    @import '../../css/home/home.scss';
</style>
