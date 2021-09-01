<template>
    <location :countries="countries"></location>
    <div class="container-fluid section-bg">
        <div class="container pt-5 pb-3 pb-md-5">
            <div class="row">
                <div class="col-12 col-md-9 p-0 d-flex align-items-center">
                    <ul class="breadcrumb">
                        <li>
                            <a href="/">
                                <div class="breadcrumb-home"></div>
                            </a>
                        </li>
                        <template v-for="(item,key) in breadcrumb" :key="key">
                            <li>
                                <div class="breadcrumb-arrow"></div>
                            </li>
                            <li class="breadcrumb-link">
                                <a :href="'/'+item.link" v-if="item.link">{{item.title}}</a>
                                <a v-else>{{item.title}}</a>
                            </li>
                        </template>
                    </ul>
                </div>
                <div class="location-main col-md-3 p-0 d-flex justify-content-end">
                    <div class="location" ref="location" data-toggle="modal" data-target="#location">
                        <div class="location-title" v-if="storage.city">{{storage.city.title}}</div>
                        <div class="location-title" v-else>Не выбрано</div>
                        <div class="location-icon"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Location from "../modal/location";
export default {
    name: "Breadcrumb",
    props: ['breadcrumb'],
    components: {
        Location,
    },
    data() {
        return {
            countries: [],
        }
    },
    created() {
        this.getCountry();
    },
    methods: {
        getCountry: function() {
            if (!sessionStorage.countries) {
                axios.get('/api/countries')
                    .then(response => {
                        let data    =   response.data;
                        if (data.hasOwnProperty('data')) {
                            data    =   data.data;
                            this.countries  =   data;
                            sessionStorage.countries    =   JSON.stringify(data);
                            if (this.storage.city === '') {
                                this.storage.city   =   this.countries[0].city_id[0];
                            }
                        }
                    }).catch(error => {
                        console.log(error.response);
                    });
            } else {
                this.countries  =   JSON.parse(sessionStorage.countries);
                if (this.storage.city === '') {
                    this.storage.city   =   this.countries[0].city_id[0];
                }
            }
        }
    }
}
</script>

<style lang="scss">
.breadcrumb {
    background: transparent;
    padding: 0 0 5px 0;
    margin: 0;
    color: white;
    & > li {
        display: flex;
        align-items: center;
        padding: 0;
        margin: 0 2px 0 2px;
        & > a {
            padding: 0;
            color: inherit;
            text-decoration: none !important;
        }
    }
    &-link {
        line-height: 1.2;
        font-size: 16px;
        font-weight: bold;
    }
    &-arrow, &-home {
        background: url('/img/logo/right-arrow-white.svg') no-repeat center;
        background-size: contain;
        width: 20px;
        height: 20px;
    }
    &-arrow {
        background-size: 50%;
    }
    &-home {
        background-image: url('/img/logo/home-white.svg');
    }
}
</style>
