<template>
    <div class="container-fluid">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 p-2">
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
                                <div>Пойск</div>
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
            }
        }
    },
    created() {
        this.getFilter();
    },
    methods: {
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
