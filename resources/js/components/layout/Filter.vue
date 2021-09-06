<template>
    <div class="filter">
        <div class="filter-title" :class="{'filter-title-open':price,'filter-title-close':!price}" @click="price = !price">Средний чек</div>
        <div class="filter-price" :class="{'filter-close':!price}">
            <div class="filter-price-item" v-for="(sum,key) in prices" :key="key" @click="setPriceVal(key)">
                <div class="filter-price-item-checkbox" :class="{'filter-rating-item-checkbox-checked':sum.checked}"></div>
                <div class="filter-price-item-title">
                    <template v-if="!sum.max.status">От </template>
                    <span v-if="sum.min.status">{{ sum.min.sum }}</span>
                    <span v-if="sum.min.status && sum.max.status"> - </span>
                    <template v-if="!sum.min.status">До </template>
                    <span v-if="sum.max.status">{{ sum.max.sum }}</span> KZT
                </div>
            </div>

        </div>
        <div class="filter-title" :class="{'filter-title-open':rating,'filter-title-close':!rating}" @click="rating = !rating">Рейтинг</div>
        <div class="filter-rating" :class="{'filter-close':!rating}">
            <div class="filter-rating-item" @click="setRatingVal(0)">
                <div class="filter-rating-item-checkbox" :class="{'filter-rating-item-checkbox-checked':ratings[0].checked}"></div>
                <div class="filter-rating-item-stars">
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-count">5.0 - 4.0</div>
                </div>
            </div>
            <div class="filter-rating-item" @click="setRatingVal(1)">
                <div class="filter-rating-item-checkbox" :class="{'filter-rating-item-checkbox-checked':ratings[1].checked}"></div>
                <div class="filter-rating-item-stars">
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-count">4.0 - 3.0</div>
                </div>
            </div>
            <div class="filter-rating-item" @click="setRatingVal(2)">
                <div class="filter-rating-item-checkbox" :class="{'filter-rating-item-checkbox-checked':ratings[2].checked}"></div>
                <div class="filter-rating-item-stars">
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-count">3.0 - 2.0</div>
                </div>
            </div>
            <div class="filter-rating-item" @click="setRatingVal(3)">
                <div class="filter-rating-item-checkbox" :class="{'filter-rating-item-checkbox-checked':ratings[3].checked}"></div>
                <div class="filter-rating-item-stars">
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star filter-rating-item-star-sel"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-star"></div>
                    <div class="filter-rating-item-count">2.0 - 1.0</div>
                </div>
            </div>
        </div>
        <template v-for="(tag,key) in tags" :key="key">
            <div class="filter-title" :class="{'filter-title-open':tag.open,'filter-title-close':!tag.open}" @click="tag.open = !tag.open">{{tag.title}}</div>

            <div class="filter-dropdown" :class="{'filter-close':!tag.open}">
                <div class="filter-dropdown-title" :class="{'filter-dropdown-title-open':tag.openList,'filter-dropdown-title-close':!tag.openList}" @click="tag.openList = !tag.openList">
                    <div>Выберите из списка</div>
                </div>
                <div class="filter-dropdown-list" :class="{'filter-close':!tag.openList}">
                    <div class="filter-dropdown-list-item" v-for="(item,optionKey) in tag.tags_option" :key="optionKey" @click="setTagVal(key,optionKey)">
                        <div class="filter-dropdown-list-item-icon" :class="{'filter-dropdown-list-item-icon-checked':item.checked}"></div>
                        <div class="filter-dropdown-list-item-title">{{item.title}}</div>
                    </div>
                </div>
            </div>

        </template>
        <div class="filter-title" :class="{'filter-title-open':other,'filter-title-close':!other}" @click="other = !other">Дополнительно</div>
        <div class="filter-dropdown" :class="{'filter-close':!other}">
            <div class="filter-dropdown-title" :class="{'filter-dropdown-title-open':otherList,'filter-dropdown-title-close':!otherList}" @click="otherList = !otherList">
                <div>Выберите из списка</div>
            </div>
            <div class="filter-dropdown-list" :class="{'filter-close':!otherList}">
                <div class="filter-dropdown-list-item" v-for="(item,key) in others" :key="key" @click="setOtherValue(key)">
                    <div class="filter-dropdown-list-item-icon" :class="{'filter-dropdown-list-item-icon-checked':item.checked}"></div>
                    <div class="filter-dropdown-list-item-title">{{item.title}}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['filter'],
    name: "Filter",
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
            ratings: [{max:5,min:4,checked:false},{max:4,min:3,checked:false},{max:3,min:2,checked:false},{max:2,min:1,checked: false}],
            tags: [],
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
            this.setFilter();
        },
        setTagVal: function(key,optionKey) {
            this.tags[key].tags_option[optionKey].checked   =   !this.tags[key].tags_option[optionKey].checked;
            this.setFilter();
        },
        setPriceVal: function (key) {
            this.prices[key].checked    =   !this.prices[key].checked;
            this.setFilter();
        },
        setRatingVal: function(key) {
            this.ratings[key].checked   =   !this.ratings[key].checked;
            this.setFilter();
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
    .filter {
        position: relative;
        width: 100%;
        background: #fff;
        box-shadow: 0 0 2px 0 rgba(0,0,0,.1);
        border-radius: 5px;
        font-size: 12px;
        color: #57a283;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        &-price {
            border-bottom: 1px solid #e6f1ec;
            padding: 0 15px 15px 15px;
            display: flex;
            flex-direction: column;
            row-gap: 10px;
            position: relative;
            overflow: hidden;
            &-item {
                display: flex;
                cursor: pointer;
                gap: 10px;
                &-checkbox {
                    width: 20px;
                    height: 20px;
                    border-radius: 3px;
                    background: #e6f1ec no-repeat center;
                    background-size: 70%;
                    &-checked {
                        background-image: url('/img/logo/check.png');
                    }
                }
                &-stars {
                    display: flex;
                    gap: 5px;
                    align-items: center;
                }
                &-title {
                    font-size: 12px;
                    font-weight: bold;
                    & > span {
                        color: #000;
                    }
                }
            }
        }
        &-rating {
            border-bottom: 1px solid #e6f1ec;
            padding: 0 15px 15px 15px;
            display: flex;
            flex-direction: column;
            row-gap: 10px;
            overflow: hidden;
            &-item {
                display: flex;
                cursor: pointer;
                gap: 10px;
                &-count {
                    line-height: 1;
                    background: #e6f1ec;
                    padding: 3px 5px 3px 5px;
                    border-radius: 3px;
                    font-size: 11px;
                    margin-left: 5px;
                }
                &-checkbox {
                    width: 20px;
                    height: 20px;
                    border-radius: 3px;
                    background: #e6f1ec no-repeat center;
                    background-size: 70%;
                    &-checked {
                        background-image: url('/img/logo/check.png');
                    }
                }
                &-stars {
                    display: flex;
                    gap: 5px;
                    align-items: center;
                }
                &-star {
                    width: 16px;
                    height: 16px;
                    background: url('/img/logo/star-whitesmoke.svg') no-repeat center;
                    background-size: contain;
                    &-sel {
                        background-image: url('/img/logo/star-orange.svg');
                    }
                }
            }
        }
        &-title {
            padding: 15px;
            font-weight: bold;
            color: #000;
            position: relative;
            cursor: pointer;
            &-open:after {
                content: '';
                position: absolute;
                width: 7px;
                height: 7px;
                border: 2px solid #57a283;
                transform: rotate(
                        45deg
                );
                border-bottom: none;
                border-right: none;
                right: 20px;
                top: 20px;
            }
            &-close:after {
                content: '';
                position: absolute;
                width: 7px;
                height: 7px;
                border: 2px solid #57a283;
                transform: rotate(
                        45deg
                );
                border-top: none;
                border-left: none;
                right: 20px;
                top: 20px;
            }
        }
        &-dropdown {
            border-bottom: 1px solid #e6f1ec;
            position: relative;
            &-title {
                height: 35px;
                background: #e6f1ec;
                margin: 0 15px 15px 15px;
                border-radius: 3px;
                position: relative;
                display: flex;
                align-items: center;
                padding: 0 15px 0 15px;
                cursor: pointer;
                &-open {
                    border-radius: 3px 3px 0 0;
                }
                &-open:after, &-close:after {
                    content: '';
                    position: absolute;
                    width: 7px;
                    height: 7px;
                    border: 2px solid #57a283;
                    transform: rotate(
                            45deg
                    );
                    border-bottom: none;
                    border-right: none;
                    right: 15px;
                    top: 15px;
                }
                &-close:after {
                    border: 2px solid #57a283;
                    border-top: none;
                    border-left: none;
                }
            }
            &-list {
                position: absolute;
                background: #e6f1ec;
                color: #57a283;
                left: 15px;
                right: 15px;
                overflow: auto;
                border-radius: 0 0 3px 3px;
                cursor: pointer;
                padding: 10px 0 10px 0;
                max-height: 200px;
                top: 35px;
                z-index: 3;
                &-item {
                    display: flex;
                    align-items: center;
                    height: 35px;
                    padding: 0 15px 0 15px;
                    gap: 15px;
                    &-icon {
                        width: 20px;
                        height: 20px;
                        background: #fff no-repeat center;
                        background-size: 70%;
                        border-radius: 3px;
                        &-checked {
                            background-image: url('/img/logo/check.png');
                        }
                    }
                }
            }
            &:last-child {
                border: none;
                padding-bottom: 15px;
                & > .filter-dropdown-title {
                    margin-bottom: 0;
                }
            }
        }
        &-selectbox {

        }
        &-close {
            height: 0 !important;
            padding: 0 !important;
            overflow: hidden;
        }
    }
    @media only screen and (max-width: 768px) {
        .filter {
            font-size: 11px !important;
        }
        .result {
            &-body {
                &-header {
                    font-size: 11px !important;
                    &-sort {
                        &-dropdown {
                            width: 120px !important;
                        }
                    }
                }
            }
        }
    }
</style>
