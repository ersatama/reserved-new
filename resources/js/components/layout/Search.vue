<template>
    <div class="container-fluid">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 p-2">
                    <div class="search-text_input">
                        <div class="search-text_input-main">
                            <div class="search-text_input-main-icon"></div>
                            <div class="search-text_input-main-close" v-show="text !== ''" @click="text = ''"></div>
                            <input type="text" v-model="text" placeholder="Поиск" @focus="searchView = true" @input="startSearch" @mousedown.stop @compositionupdate="compositionUpdate($event)">
                            <div class="search-text_input-main-list" v-if="searchView" @mousedown.stop>
                                <template v-if="text !== ''">
                                    <template v-if="search.length > 0">
                                        <a :href="'/home/'+item.category_id.slug+'/'+item.id" class="search-text_input-main-list-option" v-for="(item,key) in search" :key="key">
                                            <div class="search-text_input-main-list-option-icon" :style="{'background-image': 'url('+item.image+')'}"></div>
                                            <div class="search-text_input-main-list-option-detail">
                                                <div class="search-text_input-main-list-option-detail-title">{{item.title}}</div>
                                                <div class="search-text_input-main-list-option-detail-desc">{{item.description}}</div>
                                            </div>
                                        </a>
                                    </template>
                                    <template v-else>
                                        <div class="search-text_input-main-list-start">По вашему запросу ничего не найдено</div>
                                    </template>
                                </template>
                                <template v-else>
                                    <div class="search-text_input-main-list-start">Здесь будет отображаться список найденных заведений</div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="search-layout">
                        <div class="search-layout-item">
                            <div class="search-layout-item-title" @click="price = !price">Средний чек</div>
                            <div class="search-layout-item-select" :class="{'search-layout-item-select-close':!price}">
                                <div class="search-layout-item-select-option" v-for="(sum,key) in prices" :key="key" @click="setPriceVal(key)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':sum.checked}"></div>
                                    <div class="search-layout-item-select-option-title">
                                        <template v-if="!sum.max.status">От </template>
                                        <span v-if="sum.min.status">{{ sum.min.sum }}</span>
                                        <span v-if="sum.min.status && sum.max.status"> - </span>
                                        <template v-if="!sum.min.status">До </template>
                                        <span v-if="sum.max.status">{{ sum.max.sum }}</span> KZT
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="search-layout-item">
                            <div class="search-layout-item-title" @click="rating = !rating">Рейтинг</div>
                            <div class="search-layout-item-select" :class="{'search-layout-item-select-close':!rating}">
                                <div class="search-layout-item-select-option" @click="setRatingVal(0)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':ratings[0].checked}"></div>
                                    <div class="search-layout-item-select-option-stars">
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-rating">5.0</div>
                                    </div>
                                </div>
                                <div class="search-layout-item-select-option" @click="setRatingVal(1)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':ratings[1].checked}"></div>
                                    <div class="search-layout-item-select-option-stars">
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-rating">4.0</div>
                                    </div>
                                </div>
                                <div class="search-layout-item-select-option" @click="setRatingVal(2)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':ratings[2].checked}"></div>
                                    <div class="search-layout-item-select-option-stars">
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-rating">3.0</div>
                                    </div>
                                </div>
                                <div class="search-layout-item-select-option" @click="setRatingVal(3)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':ratings[3].checked}"></div>
                                    <div class="search-layout-item-select-option-stars">
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star search-layout-item-select-option-star-sel"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-star"></div>
                                        <div class="search-layout-item-select-option-rating">2.0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <template v-for="(tag,key) in tags" :key="key">
                            <div class="search-layout-item">
                                <div class="search-layout-item-title" @click="tag.open = !tag.open">{{tag.title}}</div>
                                <div class="search-layout-item-select" :class="{'search-layout-item-select-close':!tag.open}">
                                    <div class="search-layout-item-select-option" v-for="(item,optionKey) in tag.tags_option" :key="optionKey" @click="setTagVal(key,optionKey)">
                                        <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':item.checked}"></div>
                                        <div class="search-layout-item-select-option-title">{{item.title}}</div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="search-layout-item">
                            <div class="search-layout-item-title" @click="other = !other">Прочее</div>
                            <div class="search-layout-item-select" :class="{'search-layout-item-select-close':!other}">
                                <div class="search-layout-item-select-option" v-for="(item,key) in others" :key="key" @click="setOtherValue(key)">
                                    <div class="search-layout-item-select-option-checkbox" :class="{'search-layout-item-select-option-checkbox-checked':item.checked}"></div>
                                    <div class="search-layout-item-select-option-title">{{item.title}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="search-layout-item">
                            <div class="search-layout-item-button" @click="setFilter()">
                                <div>Поиск</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search",
    data() {
        return {
            price: false,
            prices: [
                {min:{status:false,sum:0},max:{status:true,sum:1500},checked:false},
                {min:{status:true,sum:1500},max:{status:true,sum:5000},checked:false},
                {min:{status:true,sum:5000},max:{status:true,sum:10000},checked:false},
                {min:{status:true,sum:10000},max:{status:true,sum:20000},checked:false},
                {min:{status:true,sum:20000},max:{status:false,sum:0},checked:false},
            ],
            rating: false,
            ratings: [{max:5,min:4,checked:false},{max:4,min:3,checked:false},{max:3,min:2,checked:false},{max:2,min:1,checked: false}],           tags: [],
            other: false,
            otherList: false,
            others: [],
            filterItem: {
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
            timer: null,
            search: [],
            searchView: false,
            text: ''
        }
    },
    created() {
        this.getFilter();
        let self    =   this;
        window.addEventListener('mousedown',function() {
            self.searchView =   false;
        });
    },
    methods: {
        compositionUpdate: function(event)
        {
            this.text   =   event.data;
        },
        startSearch: function() {
            if (this.text.trim() !== '') {
                clearTimeout(this.timer);
                let self    =   this;
                this.timer  =   setTimeout(function() {
                    self.getSearchOrganizations();
                },200);
            } else {
                this.search =   [];
            }
        },
        getSearchOrganizations: function() {
            axios.get('/api/organization/search/'+this.text.trim()).then(response => {
                this.search =   response.data.data;
            });
        },
        setOtherValue: function(key) {
            this.others[key].checked    =   !this.others[key].checked;
        },
        setTagVal: function(key,optionKey) {
            this.tags[key].tags_option[optionKey].checked   =   !this.tags[key].tags_option[optionKey].checked;
        },
        setPriceVal: function (key) {
            this.prices[key].checked    =   !this.prices[key].checked;
        },
        setRatingVal: function(key) {
            this.ratings[key].checked   =   !this.ratings[key].checked;
        },
        getFilter: function() {
            axios.get('/api/organization/filter').then(response => {
                let filter  =   response.data;
                this.tags   =   filter.tags_id;
                this.others =   filter.tags_option_id;
                this.setFilterInit();
            }).catch(error => {
                console.log(error.response);
            });
        },
        setFilterPrice: function () {
            let price   =   {status:false,min:0,max:0};
            this.prices.forEach(item => {
                if (item.checked) {
                    if (item.min.status && !price.status) {
                        price.min   =   item.min.sum;
                    } else if (!item.min.status) {
                        price.min   =   0;
                    }
                    if (item.max.status && price.max < item.max.sum) {
                        price.max   =   item.max.sum;
                    } else if (!item.max.status) {
                        price.max   =   0;
                    }
                    price.status    =   true;
                }
            });
            if (price.min === 0 && price.max === 0) {
                price.status    =   false;
            }
            this.filterItem.price   =   price;
        },
        setFilterRating: function() {
            let ratings   =   {status:false,min:0,max:0};
            this.ratings.forEach(item => {
                if (item.checked) {
                    if (item.max > ratings.max) {
                        ratings.max =   item.max;
                    }
                    if (ratings.min > item.min || ratings.min === 0) {
                        ratings.min =   item.min;
                    }
                    ratings.status    =   true;
                }
            });
            if (ratings.min === 0 && ratings.max === 0) {
                ratings.status    =   false;
            }
            this.filterItem.ratings   =   ratings;
        },
        setFilterTags: function() {
            let tags    =   [];
            this.tags.forEach(item => {
                item.tags_option.forEach(option => {
                    if (option.checked) {
                        tags.push(option.id);
                    }
                });
            });
            this.filterItem.tags    =   tags;
        },
        setFilterOthers: function() {
            let others  =   [];
            this.others.forEach(item => {
                if (item.checked) {
                    others.push(item.id);
                }
            });
            this.filterItem.tags    =   this.filterItem.tags.concat(others);
        },
        setFilterInit: function() {
            this.setFilterPrice();
            this.setFilterRating();
            this.setFilterTags();
            this.setFilterOthers();
        },
        setFilter: function() {
            this.setFilterPrice();
            this.setFilterRating();
            this.setFilterTags();
            this.setFilterOthers();
            this.$emit('filterUpdate',JSON.parse(JSON.stringify(this.filterItem)));
        },
    }
}
</script>

<style lang="scss">
    @import '../../../css/layout/Search.scss';
</style>
