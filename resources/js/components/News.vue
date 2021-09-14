<template>
    <Header></Header>
    <profile-section></profile-section>
    <loading v-if="Loading"></loading>
    <div v-else-if="news.length > 0" class="container-fluid p-0 m-0 home-bg-color">
        <div class="container p-0">
            <div class="row m-0">
                <div class="col-12">
                    <div class="news">
                        <div class="news-item" v-for="(item,key) in news" :key="key">
                            <div class="news-item-header">
                                <div class="news-item-header-icon">
                                    <img :src="item.organization.image" :alt="item.organization.title">
                                </div>
                                <div class="news-item-header-detail">
                                    <a :href="'/home/'+item.organization.category_id.slug+'/'+item.organization.id" class="news-item-header-detail-title">{{item.organization.title}}</a>
                                    <div class="news-item-header-detail-time">{{item.created_at}}</div>
                                </div>
                            </div>
                            <div class="news-header" v-if="item.title.trim() !== ''">{{item.title}}</div>
                            <div class="news-description" v-if="item.description.trim() !== ''">{{item.description}}</div>
                            <div class="news-item-screen" v-if="item.images.length > 0">
                                <img :src="item.images[0].image">
                            </div>
                            <a :href="'/home/'+item.organization.category_id.slug+'/'+item.organization.id" class="news-item-header-btn">Забронировать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <not-found v-else :params="NotFound" ></not-found>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import Loading from './layout/Loading';
import NotFound from './layout/Not-found';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
        Loading,
        NotFound
    },
    name: "News",
    data() {
        return {
            NotFound: {
                img: '/img/logo/reserved.png',
                title: 'Не найдено',
                description: 'Подпишитесь на заведение чтобы получать последние новости, акции.'
            },
            Loading: true,
            status: true,
            page: 1,
            news: [],
            user: false
        }
    },
    created() {
        this.setUser();
        this.getNews();
    },
    mounted() {
        this.scrollEvent();
    },
    methods: {
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
        scrollEvent: function() {
            let self    =   this;
            window.document.body.onscroll = function() {
                let height = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight;
                if ((document.documentElement.offsetHeight - height) < 800) {
                    self.getNews();
                }
            }
        },
        getNews: function() {
            if (this.status) {
                this.status =   false;
                if (!this.user) {
                    axios.get('/api/news/list/'+this.page).then(response => {
                        let data    =   response.data.data;
                        if (data.length === 15) {
                            this.page   =   2;
                            this.status =   true;
                        }
                        this.news       =   this.news.concat(data);
                        this.Loading    =   false;
                    }).catch(error => {
                        this.status     =   false;
                        this.Loading    =   false;
                    });
                } else {
                    axios.get('/api/news/subscribes/'+this.user.id+'/'+this.page).then(response => {
                        let data    =   response.data.data;
                        if (data.length === 15) {
                            this.page   =   2;
                            this.status =   true;
                        }
                        this.news       =   this.news.concat(data);
                        this.Loading    =   false;
                    }).catch(error => {
                        this.status     =   false;
                        this.Loading    =   false;
                    });
                }
            }
        }
    }
}
</script>

<style lang="scss">
    .news {
        display: flex;
        flex-direction: column;
        width: 600px;
        margin: 50px auto 50px auto;
        gap: 20px;
        &-header {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            padding: 0 25px 0 25px;
        }
        &-description {
            font-size: 13px;
            color: grey;
            padding: 0 25px 0 25px;
        }
        &-item {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e6f1ec;
            display: flex;
            flex-direction: column;
            gap: 15px;
            &-header {
                display: flex;
                gap: 20px;
                align-items: center;
                border-bottom: 1px solid #e6f1ec;
                padding: 20px;
                position: relative;
                &-btn {
                    outline: none;
                    border: none;
                    background: #e6f1ec;
                    color: #57a283 !important;
                    font-size: 12px;
                    padding: 10px 15px 10px 15px;
                    border-radius: 30px;
                    font-weight: bold;
                    text-decoration: none !important;
                    text-align: center;
                    margin: 0 25px 25px 25px;
                    &:hover {
                        color: #fff !important;
                        background: #57a283;
                    }
                }
                &-icon {
                    overflow: hidden;
                    border-radius: 30px;
                    & > img {
                        width: 50px;
                        height: 50px;
                    }
                }
                &-detail {
                    &-title {
                        font-size: 14px;
                        font-weight: bold;
                        padding: 0;
                        display: block;
                        text-decoration: none !important;
                        color: #000 !important;
                    }
                    &-time {
                        font-size: 12px;
                        color: grey;
                    }
                }
            }
            &-screen {
                margin: 0 20px 10px 20px;
                border-radius: 10px;
                overflow: hidden;
                position: relative;
                & > img {
                    width: 100%;
                    display: block;
                }
            }
        }
    }
    @media only screen and (max-width: 768px) {
        .news {
            width: auto;
            margin: 20px auto 20px auto;
            &-header {
                font-size: 12px;
                padding: 0 20px 0 20px;
            }
            &-description {
                font-size: 11px;
                padding: 0 20px 0 20px;
            }
            &-item {
                gap: 10px;
                &-screen {
                    margin: 0 20px 20px 20px;
                    border-radius: 5px;
                }
                &-header {
                    gap: 10px;
                    &-icon {
                        width: 40px;
                        height: 40px;
                    }
                    &-btn {
                        font-size: 11px;
                        right: 20px;
                        margin: 0 20px 20px 20px;
                    }
                }
            }
        }
    }
</style>
