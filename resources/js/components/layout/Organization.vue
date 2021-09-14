<template>
    <loading v-if="Loading"></loading>
    <div class="container-fluid py-3 py-md-4 item-bg" v-else-if="category">
        <div class="container">
            <div class="row">
                <div class="result">
                    <div class="result-body">
                        <div class="result-body-header">
                            <div class="result-body-header-count" v-if="found >= 0">Найдено заведении <span>{{found}}</span></div>
                            <div class="result-body-header-sort">
                                <div class="result-body-header-sort-title">Сортировка:</div>
                                <div class="result-body-header-sort-dropdown">
                                    <div class="result-body-header-sort-dropdown-title" @click="selected.show = !selected.show">{{ sort[selected.index].title }}</div>
                                    <div class="result-body-header-sort-dropdown-list" :class="{'result-body-header-sort-dropdown-list-open':selected.show}">
                                        <div class="result-body-header-sort-dropdown-list-item" v-for="(item,key) in sort" :key="key" @click=" selectedValue(key); ; selected.show = false">{{item.title}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="result-body-main">
                            <Card :organization="organization" v-for="(organization,key) in organizations" :key="key"></Card>
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
import Card from '../layout/Card';
export default {
    props: ['category'],
    name: "Organization",
    components: {
        Loading,
        NotFound,
        Card
    },
    data() {
        return  {
            NotFound: {
                img: '/img/logo/reserved.png',
                title: 'Не найдено',
                description: 'Возможно категория которую вы искали называется иначе.'
            },
            selected: {
                index: 0,
                show: false,
            },
            filter: {
                price: {
                    status: false,
                    min: 0,
                    max: 0,
                },
                ratings: {
                    status: false,
                    min: 0,
                    max: 0,
                },
                tags: [],
            },
            sort: [{title:'По рейтингу'},{title:'Сначала дорогие'},{title:'Сначала дешевые'}],
            Loading: true,
            status: true,
            city: 1,
            found: -1,
            page: 1,
            init: true,
            organizations: [],
        }
    },
    created() {
        this.setFilter();
        this.getCountOrganizationsByCategoryId();
        this.getOrganizationsByCategoryId();
    },
    mounted() {
        this.scrollEvent();
    },
    methods: {
        scrollEvent: function() {
            let self    =   this;
            window.document.body.onscroll = function() {
                let height = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight;
                if ((document.documentElement.offsetHeight - height) < 800) {
                    self.getOrganizationsByCategoryId();
                }
            }
        },
        selectedValue: function(key) {
            this.init   =   true;
            this.page   =   1;
            this.status =   true;
            this.selected.index = key;
            this.getCountOrganizationsByCategoryId();
            this.getOrganizationsByCategoryId();
        },
        filterUpdate: function(data) {
            this.init   =   true;
            this.page   =   1;
            this.status =   true;
            this.filter =   data;
        },
        getCountOrganizationsByCategoryId: function() {
            axios.post('/api/category/count/organizations/'+this.category.id+'/'+this.city+'/'+this.page,this.filter)
                .then(response => {
                    this.found  =   response.data;
                }).catch(error => {
                    this.found  =   -1;
                });
        },
        getOrganizationsByCategoryId: function() {
            if (this.category && this.status) {
                this.status =   false;
                this.filter.sort    =   this.selected.index;
                axios.post('/api/category/filter/organizations/'+this.category.id+'/'+this.city+'/'+this.page,this.filter)
                    .then(response => {
                        let data    =   response.data.data;
                        for (let i = 0; i < data.length; i++) {
                            data[i].timeTitle   =   this.getTime(data[i]);
                        }
                        if (this.init) {
                            this.init   =   false;
                            this.organizations  =   data;
                        } else {
                            this.organizations  =   this.organizations.concat(data);
                        }
                        this.Loading        =   false;
                        this.page++;
                        if (data.length === 15) {
                            this.status         =   true;
                        }
                    }).catch(error => {
                        this.Loading    =   false;
                        this.status     =   true;
                    });
            }
        },
        setFilter: function() {
            if (this.storage.city) {
                this.city =   this.storage.city.id;
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
