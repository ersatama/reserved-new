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
                                    <div class="result-body-item-map" v-if="organization.address">
                                        <div>{{organization.address}}</div>
                                    </div>
                                    <a :href="'/home/'+organization.category_id.slug+'/'+organization.id" class="p-0">
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
    name: "searchOrganization",
    components: {
        Loading,
        NotFound,
        Filter
    },
    data() {
        return  {
            NotFound: {
                img: '/img/logo/reserved-logo.png',
                title: 'Список пуст',
                description: 'Заведении не найдено'
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
            if (this.$route.query.tag && this.$route.query.tag.trim() !== '') {
                axios.get('/api/organization/tag/'+this.$route.query.tag.trim())
                    .then(response => {
                        let data    =   response.data;
                        console.log(data);
                        this.Loading    =   false;
                    }).catch(error => {
                        this.organizations   =   [];
                        this.Loading    =   false;
                    });
            } else {
                this.organizations   =   [];
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

</style>
