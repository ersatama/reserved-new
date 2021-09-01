<template>
    <Header></Header>
    <div class="container-fluid search pt-5">
        <div class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6 col-12 search-left">
                    <div>
                        <img src="/img/main/img.png" width="100%">
                    </div>
                </div>
                <div class="col-md-6 col-12 search-right">
                    <div>
                        <div class="search-title text-white text-center font-weight-bold">Food delivery and more</div>
                        <div class="h6 text-white text-center mt-4">Groceries, shops, pharmacies, anything!</div>
                        <div class="search-input mt-4">
                            <div class="search-input-main">
                                <input type="text" class="w-100 shadow">
                            </div>
                            <button class="search-input-btn">Поиск</button>
                        </div>
                        <div class="search-current-location mt-4 text-white text-center d-table mx-auto">или найдите популярные рестораны в городе Алматы</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid wave">
        <svg viewBox="0 0 500 50" preserveAspectRatio="xMinYMin meet">
            <path d="M0,25 C150,50 350,0 500,25 L500,00 L0,0 Z" style="stroke: none; fill: #00a082;"></path>
        </svg>
    </div>
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="top-head">Откройте города, где доступен Reserved</div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="card text-center border-0">
                    <div class="card-header bg-transparent d-flex justify-content-center">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link text-secondary font-weight-bold" :class="{active: location.sel,'main-color':location.sel}" role="button" @click="location.sel = true">Казахстан</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary font-weight-bold" :class="{active: !location.sel,'main-color':!location.sel}" role="button" @click="location.sel = false">Другие страны</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5" :class="{'d-none': !location.sel}">
            <div class="col-12 col-md-6 col-lg-3 p-3" v-for="(city,id) in location.countries[location.country]['list']" :key="id">
                <div class="card border-1 rounded-lg">
                    <div class="card-body">{{city.title}}</div>
                </div>
            </div>
        </div>
        <div class="row mt-5" :class="{'d-none': location.sel}">
            <div class="col-12 col-md-6 col-lg-3 p-3" v-for="(country,id) in location.countries" :key="id">
                <div class="card border-1 rounded-lg">
                    <div class="card-body">{{country.title}}</div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="top-head">Top restaurants and more in Reserved</div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-6 col-lg-3 p-3" v-for="(item,key) in top" :key="key">
                <div class="card border-0 top-card overflow-hidden">
                    <div class="card-img">
                        <img class="card-img-top" :src="item.img" width="100%" height="150">
                    </div>
                    <div class="card-body p-0 mt-4">
                        <h5 class="card-title text-center font-weight-bold">{{ item.title }}</h5>
                        <p class="card-text mt-2">Some quick example text to build on the card title.</p>
                        <button class="btn card-btn btn-block top-btn">Go somewhere</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid wave mt-5">
        <svg viewBox="0 0 500 50" preserveAspectRatio="xMinYMin meet" style="background: #00a082;">
            <path d="M0,25 C150,50 350,0 500,25 L500,00 L0,0 Z" style="stroke: none; fill: #fff;"></path>
        </svg>
    </div>
    <div class="container-fluid search pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="top-head text-white">Хотите чего-то большего?</div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 col-md-6 p-5">
                    <div class="main-img">
                        <img class="card-img-top" src="/img/main/img-8.jpg" alt="Card image cap" >
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center p-5">
                    <div class="card border-0 top-card overflow-hidden bg-transparent text-white">
                        <div class="card-body p-0 m-2">
                            <h1 class="card-title main-title">Станьте нашим партнёром</h1>
                            <p class="card-text main-desc h5 mt-3">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <button class="btn main-btn text-white font-weight-bold mt-3">Стать партнёром</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 d-flex align-items-center text-right p-5">
                    <div class="card border-0 top-card overflow-hidden bg-transparent text-white">
                        <div class="card-body p-0 m-2">
                            <h1 class="card-title main-title">Начни работу в Reserved</h1>
                            <p class="card-text main-desc h5 mt-3">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <button class="btn main-btn text-white font-weight-bold mt-3">Подать заявку</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-5">
                    <div class="main-img">
                        <img class="card-img-top" src="/img/main/img-9.jpg" alt="Card image cap" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid wave">
        <svg viewBox="0 0 500 50" preserveAspectRatio="xMinYMin meet" style="background: #1d1d1d;">
            <path d="M0,25 C150,50 350,0 500,25 L500,00 L0,0 Z" style="stroke: none; fill: #00a082;"></path>
        </svg>
    </div>
    <Footer></Footer>
</template>
<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
export default {
    components: {
        Header,
        Footer
    },
    name: "Main",
    data() {
        return {
            top: [
                {
                    img: '/img/main/img.jpg',
                    title: 'McDonald\'s',
                },
                {
                    img: '/img/main/img-1.jpg',
                    title: 'KFC',
                },
                {
                    img: '/img/main/img-2.jpg',
                    title: 'Burger King',
                },
                {
                    img: '/img/main/img-3.jpg',
                    title: 'Subway',
                },
                {
                    img: '/img/main/img-4.jpg',
                    title: 'Pizza Hut',
                },
                {
                    img: '/img/main/img-5.jpg',
                    title: 'Taco Bell',
                },
                {
                    img: '/img/main/img-6.jpg',
                    title: 'Papa John\'s',
                },
                {
                    img: '/img/main/img-7.jpg',
                    title: 'Dunkin Donuts',
                },
            ],
            location: {
                sel: true,
                country: 0,
                countries: [
                    {
                        title: 'Kazakhstan',
                        list: [
                            {
                                title: 'Almaty',
                            },
                            {
                                title: 'Nur-Sultan',
                            },
                            {
                                title: 'Semey',
                            },
                            {
                                title: 'Aktau',
                            },
                            {
                                title: 'Karaganda',
                            },
                        ]
                    }
                ]
            },
        }
    },
    created() {
        window.location.href = '/home';
    },
    methods: {

    }
}
</script>

<style lang="scss">
    .card {
        &-img {
            border-radius: 100%;
            overflow: hidden;
        }
        &-btn {
            background-color: #FF8008;
            color: #fff;
            border-radius: 30px;
            height: 44px;
            padding: 0 30px 0 30px;
        }
    }
    .top {
        &-head {
            font-size: 40px;
            text-align: center;
            font-family: 'Lobster', cursive;
        }
        &-card {
            border-radius: 10px;
        }
        &-btn {
            border-radius: 30px;
        }
    }
    .main {
        &-color {
            color: #FF8008 !important;
        }
        &-btn {
            background-color: #FF8008;
            color: #fff;
            border-radius: 30px;
            height: 44px;
            padding: 0 30px 0 30px;
        }
        &-img {
            border-radius: 100%;
            overflow: hidden;
            position: relative;
            & > img {
                display: table;
            }
        }
        &-title {
            font-family: 'Lobster', cursive;
        }
        &-desc {
            font-family: 'Lobster', cursive;
        }
    }
    .search {
        background-color: #00a082;
        min-height: 550px;
        &-right, &-left {
            display: flex;
            justify-content: center;
            padding: 0 50px 0 50px;
        }
        &-current {
            &-location {
                border-bottom: 1px solid white;
                cursor: pointer;
            }
        }
        &-title {
            font-size: 64px;
            line-height: 1;
        }
        &-input {
            display: grid;
            grid-template-columns: auto 100px;
            grid-gap: 10px;
            font-size: 13px;
            &-btn {
                height: 44px;
                border-radius: 30px;
                border: none;
                font-weight: bold;
                background-color: #FF8008;
                color: #fff;
            }
            &-main {
                & > input {
                    border-radius: 50px;
                    height: 100%;
                    border: none;
                    outline: none;
                }
            }
        }
    }
    .wave {
        padding: 0 !important;
    }
</style>
