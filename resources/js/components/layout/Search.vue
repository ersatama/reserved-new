<template>
    <div class="container-fluid">
        <div class="container p-0">
            <div class="search-layout">
                <div class="search-layout-text">
                    <div class="search-layout-text-icon"></div>
                    <div class="search-layout-text-cancel" v-if="search !== ''" @click="search = ''"></div>
                    <input type="text" class="search-layout-text-input" placeholder="Поиск" v-model="search" @mousedown.stop @focus.stop="searchView = true;">
                    <div class="search-layout-list" v-if="searchView && organizations.length && search !== ''" @mousedown.stop>
                        <a :href="'/home/'+organization.category_id.slug+'/'+organization.id" class="search-layout-list-link" v-for="(organization,key) in organizations" :key="key">
                            <div class="search-layout-list-item">
                                <div class="search-layout-list-item-icon" :style="{'background-image':'url('+organization.image+')'}"></div>
                                <div class="search-layout-list-item-detail">
                                    <div class="search-layout-list-item-title">
                                        <div>{{ organization.title }}</div>
                                    </div>
                                    <div class="search-layout-list-item-stars">
                                        <div class="search-layout-list-item-star" :class="{'search-layout-list-item-star-sel':(organization.rating >= 0.5)}"></div>
                                        <div class="search-layout-list-item-star" :class="{'search-layout-list-item-star-sel':(organization.rating >= 1.5)}"></div>
                                        <div class="search-layout-list-item-star" :class="{'search-layout-list-item-star-sel':(organization.rating >= 2.5)}"></div>
                                        <div class="search-layout-list-item-star" :class="{'search-layout-list-item-star-sel':(organization.rating >= 3.5)}"></div>
                                        <div class="search-layout-list-item-star" :class="{'search-layout-list-item-star-sel':(organization.rating >= 4.5)}"></div>
                                        <div class="search-layout-list-item-rating" v-if="organization.rating">{{organization.rating}}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="search-tags">
                <div class="search-tag" v-for="(tag,key) in tags" :key="key">{{tag.title}}</div>
                <div class="search-tag" v-for="(tag,key) in tags" :key="key">{{tag.title}}</div>
                <div class="search-tag" v-for="(tag,key) in tags" :key="key">{{tag.title}}</div>
                <div class="search-tag" v-for="(tag,key) in tags" :key="key">{{tag.title}}</div>
                <div class="search-tag" v-for="(tag,key) in tags" :key="key">{{tag.title}}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Search",
    data() {
        return {
            search: '',
            organizations: [],
            timeOut: null,
            tags: [],
            searchView: false,
        }
    },
    created() {
        this.getTags();
        let self    =   this;
        window.addEventListener('mousedown',function () {
            self.searchView =   false;
        });
    },
    watch: {
        search: function() {
            if (this.search.trim() !== '') {
                this.searchOrganizations();
            } else {
                this.organizations  =   [];
            }
        }
    },
    methods: {
        searchOrganizations: function() {
            clearTimeout(this.timeOut);
            let self    =   this;
            this.timeOut    =   setTimeout(function() {
                axios.get('/api/organization/search/'+self.search.trim()).then(response => {
                    self.organizations  =   response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },500);
        },
        getTags: function() {
            axios.get('/api/tagsOption/all').then(response => {
                this.tags   =   response.data;
            });
        }
    }
}
</script>

<style lang="scss">
    .search {
        &-layout {
            width: 500px;
            height: auto;
            background: #fff;
            margin: 20px auto 0 auto;
            border: 1px solid #e6f1ec;
            border-radius: 35px;
            position: relative;
            &-empty {
                font-size: 14px;
                text-align: center;
                padding: 25px 0 25px 0;
                color: #57a283;
                font-weight: bold;
            }
            &-list {
                position: absolute;
                width: 100%;
                background: #fff;
                z-index: 3;
                border-radius: 10px;
                box-shadow: 0 0 2px 1px rgba(0,0,0,.05);
                cursor: pointer;
                top: 50px;
                overflow: hidden;
                &-link {
                    display: block;
                    padding: 0;
                    color: inherit;
                    border-bottom: 1px solid #e6f1ec;
                    text-decoration: none !important;
                }
                &-item {
                    padding: 10px;
                    border-bottom: 1px solid #e6f1ec;
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    &-icon {
                        width: 40px;
                        height: 40px;
                        background: no-repeat center;
                        background-size: contain;
                        border-radius: 50px;
                    }
                    &-detail {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                    }
                    &-stars {
                        display: flex;
                        gap: 2px;
                        align-items: center;
                    }
                    &-star {
                        width: 12px;
                        height: 12px;
                        background: url('/img/logo/star-whitesmoke.svg') no-repeat center;
                        background-size: contain;
                        &-sel {
                            background-image: url('/img/logo/star-orange.svg');
                        }
                    }
                    &-rating {
                        font-size: 9px;
                        line-height: 1.2;
                        color: #57a283;
                        background: #e6f1ec;
                        padding: 2px 5px 2px 5px;
                        border-radius: 2px;
                        margin-left: 5px;
                    }
                    &-title {
                        font-size: 14px;
                        font-weight: bold;
                        color: #000 !important;
                        & > div {
                            text-overflow: ellipsis;
                            overflow: hidden;
                            white-space: nowrap;
                        }
                    }
                    &:last-child {
                        border-bottom: none;
                    }
                    &:hover {
                        background: rgb(250,250,250);
                    }
                }
            }
            &-text {
                margin: 10px;
                position: relative;
                &-icon {
                    width: 16px;
                    height: 16px;
                    background: url(/img/logo/search.png) no-repeat center;
                    background-size: contain;
                    position: absolute;
                    top: 50%;
                    left: 15px;
                    transform: translate(0,-50%);
                }
                &-input {
                    border: none;
                    width: 100%;
                    padding: 10px 45px 10px 45px;
                    border-radius: 25px;
                    outline: none !important;
                    background: #e6f1ec;
                    font-size: 14px;
                }
                &-cancel {
                    width: 20px;
                    height: 20px;
                    position: absolute;
                    right: 15px;
                    top: 50%;
                    transform: translate(0, -50%);
                    background: url(/img/logo/close.svg) no-repeat center;
                    background-size: 60%;
                    cursor: pointer;
                    opacity: .5;
                }
            }
        }
        &-tags {
            margin: 20px 0 0 0;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-wrap: wrap;
        }
        &-tag {
            padding: 10px 15px 10px 15px;
            background: #57a283;
            color: #fff;
            border-radius: 40px;
            cursor: pointer;
        }
    }
    @media only screen and (max-width: 768px) {
        .search {
            &-layout {
                width: auto;
                &-text {
                    margin: 5px;
                    &-input {
                        padding: 8px 42px 8px 42px;
                        font-size: 12px;
                    }
                }
                &-list {
                    top: 40px;
                    &-item {
                        &-icon {
                            width: 30px;
                            height: 30px;
                        }
                        &-title {
                            font-size: 12px;
                        }
                        &-star {
                            width: 10px;
                            height: 10px;
                        }
                    }
                }
            }
            &-tag {
                font-size: 10px;
                padding: 5px 10px 5px 10px;
            }
            &-tags {
                gap: 5px;
            }
        }
    }
</style>
