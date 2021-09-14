<template>
    <div class="result-body-item-main">
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
            <template v-if="user">
                <div class="result-body-item-subscribe" v-if="subscribe && subscribe.status === 'on'" @click="subscribeNow()">
                    <div class="result-body-item-subscribe-sel"></div>
                </div>
                <div class="result-body-item-subscribe" v-else @click="subscribeNow()">
                    <div></div>
                </div>
            </template>
            <div class="result-body-item-subscribe" data-toggle="modal" data-target="#auth_modal" v-else>
                <div></div>
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
</template>

<script>
export default {
    props: ['organization'],
    name: "Card",
    data() {
        return {
            subscribe: false,
            user: false
        }
    },
    created() {
        this.setUser();
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
                this.getSubscribe();
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

</style>
