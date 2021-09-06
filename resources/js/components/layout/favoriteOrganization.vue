<template>
    <loading v-if="Loading"></loading>
    <div class="container-fluid py-3 py-md-4 item-bg" v-else-if="organizations.length > 0 && storage.favorite.length > 0">
        <div class="container">
            <div class="row">
                <div class="result">
                    <div class="result-body">
                        <div class="result-body-main result-body-main-single">
                            <div class="result-body-item-main" v-for="(organization,key) in organizations" :key="key">
                                <div class="result-body-item">
                                    <div class="result-body-item-screen" :style="{'background-image': 'url('+organization.wallpaper+')'}">
                                        <div class="result-body-item-time">
                                            {{organization.timeTitle}}
                                        </div>
                                    </div>
                                    <div class="result-body-item-logo">
                                        <img :src="organization.image" width="60">
                                    </div>

                                    <div class="result-body-item-favorite" @click="favorite(organization.id)">
                                        <div :class="{'result-body-item-favorite-sel': storage.favorite.includes(organization.id)}"></div>
                                    </div>
                                    <a :href="'/home/'+organization.category_id.slug+'/'+organization.id" class="p-0 result-body-item-name-link">
                                        <div class="result-body-item-name">{{organization.title}}</div>
                                    </a>
                                    <div class="result-body-item-stars">
                                        <div class="result-body-item-star" :class="{'result-body-item-star-sel':(organization.rating >= 0.5)}"></div>
                                        <div class="result-body-item-star" :class="{'result-body-item-star-sel':(organization.rating >= 1.5)}"></div>
                                        <div class="result-body-item-star" :class="{'result-body-item-star-sel':(organization.rating >= 2.5)}"></div>
                                        <div class="result-body-item-star" :class="{'result-body-item-star-sel':(organization.rating >= 3.5)}"></div>
                                        <div class="result-body-item-star" :class="{'result-body-item-star-sel':(organization.rating >= 4.5)}"></div>
                                        <div class="result-body-item-rating" v-if="organization.rating">{{organization.rating}}</div>
                                    </div>
                                    <div class="result-body-item-description" v-snip="3">{{organization.description}}</div>
                                    <div class="result-body-item-detail">
                                        <div class="result-body-item-detail-price" v-if="organization.price > 0">{{organization.price}} KZT</div>
                                        <div class="result-body-item-detail-tel">
                                            <a :href="'tel:'+organization.phone" class="text-dark p-0">{{organization.phone}}</a>
                                        </div>
                                    </div>
                                    <div class="result-body-item-map">
                                        <div>{{organization.address}}</div>
                                    </div>
                                    <a v-if="category" :href="'/home/'+category.slug+'/'+organization.id" class="p-0">
                                        <div class="result-body-item-btn">Забронировать</div>
                                    </a>
                                    <a v-else :href="'/home/'+organization.category_id.slug+'/'+organization.id" class="p-0">
                                        <div class="result-body-item-btn">Забронировать</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <not-found v-else :params="NotFound" ></not-found>
</template>

<script>
import Loading from '../layout/Loading';
import NotFound from '../layout/Not-found';
import Filter from '../layout/Filter';
export default {
    props: ['category'],
    name: "Organization",
    components: {
        Loading,
        NotFound,
        Filter
    },
    data() {
        return  {
            NotFound: {
                img: '/img/logo/favorite-red.svg',
                title: 'Список пуст',
                description: 'Здесь будет отображаться список добавленных вами заведении.'
            },
            Loading: true,
            organizations: [],
        }
    },
    created() {
        this.getOrganizations();
    },
    methods: {
        getOrganizations: function() {
            if (this.storage.favorite.length > 0) {
                axios.post('/api/organization/ids',{
                    ids: this.storage.favorite
                })
                    .then(response => {
                        let data    =   response.data.data;
                        for (let i = 0; i < data.length; i++) {
                            data[i].timeTitle   =   this.getTime(data[i]);
                            this.organizations.push(data[i]);
                        }
                        if (data.length === 0) {
                            this.storage.favorite   =   [];
                            this.organizations   =   [];
                        }
                        this.Loading    =   false;
                    }).catch(error => {
                        this.storage.favorite   =   [];
                        this.organizations   =   [];
                        this.Loading    =   false;
                    });
            } else {
                this.storage.favorite   =   [];
                this.organizations  =   [];
                this.Loading    =   false;
            }
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
        getTime: function(organization) {
            let today   =   new Date();
            today       =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
            let weekDay =   today.getDay();
            let week;
            if (weekDay === 0) {
                week    =   organization.sunday;
            } else if (weekDay === 1) {
                week    =   organization.monday;
            } else if (weekDay === 2) {
                week    =   organization.tuesday;
            } else if (weekDay === 3) {
                week    =   organization.wednesday;
            } else if (weekDay === 4) {
                week    =   organization.thursday;
            } else if (weekDay === 5) {
                week    =   organization.friday;
            } else if (weekDay === 6) {
                week    =   organization.saturday;
            }
            if (week.start === week.end) {
                return 'круглосуточно';
            }
            return 'c '+this.timeConvert(week.start)+' до '+this.timeConvert(week.end);
        },
        timeConvert: function(time) {
            let converted   =   time.split(':');
            return converted[0]+':'+converted[1];
        },
    }
}
</script>

<style lang="scss">
@import '../../../css/layout/organization.scss';
</style>
