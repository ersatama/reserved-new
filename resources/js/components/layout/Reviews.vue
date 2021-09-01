<template>
    <div class="container-fluid pb-3 pb-md-5 organization-bg">
        <div class="container">
            <div class="row pt-4">
                <div class="col-12">
                    <Loading v-if="status"></Loading>
                    <template v-else-if="reviews.length > 0">
                        <div>
                            <div class="row p-0 py-md-2">
                                <div class="col-12 p-0 d-flex justify-content-center">
                                    <div class=" organization-comment-count text-secondary" v-if="reviewCount === 1">{{reviewCount}} отзыв</div>
                                    <div class=" organization-comment-count text-secondary" v-else>{{reviewCount}} отзыва</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row py-0 py-md-4 p-0 organization-comment-line" v-for="(review,key) in reviews" :key="key">
                                <div class="col-12 col-sm-6 col-md-3 p-0">
                                    <div class="organization-comment">
                                        <div class="organization-comment-icon">
                                            <div>{{review.user.name[0]}}</div>
                                        </div>
                                        <div class="organization-comment-detail">
                                            <div class="organization-comment-detail-name">
                                                <span class="organization-comment-detail-name-user">{{review.user.name}}</span>
                                                <span class="organization-comment-detail-dot text-secondary font-weight-normal">•</span>
                                                <span class="text-secondary font-weight-normal">{{review.created_at}}</span>
                                            </div>
                                            <div class="organization-comment-detail-stars">
                                                <div class="organization-comment-detail-star" :class="{'organization-comment-detail-star-sel':(review.rating >= 1)}"></div>
                                                <div class="organization-comment-detail-star" :class="{'organization-comment-detail-star-sel':(review.rating >= 2)}"></div>
                                                <div class="organization-comment-detail-star" :class="{'organization-comment-detail-star-sel':(review.rating >= 3)}"></div>
                                                <div class="organization-comment-detail-star" :class="{'organization-comment-detail-star-sel':(review.rating >= 4)}"></div>
                                                <div class="organization-comment-detail-star" :class="{'organization-comment-detail-star-sel':(review.rating >= 5)}"></div>
                                            </div>
                                            <div class="organization-comment-detail-status" v-if="review.status === 'CHECKING'">
                                                <div>На проверке</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-9 p-0 d-flex align-items-center">
                                    <div class="organization-comment-text">{{review.comment.replace(/\n/g, '<br />')}}</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="statusContinue">
                            <button class="btn-scroll" @click="getReviews()">Показать ещё</button>
                        </div>
                    </template>
                    <NotFound v-else :params="empty"></NotFound>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../layout/Loading';
import NotFound from '../layout/Not-found';
export default {
    props: ['id'],
    name: "Reviews",
    components: {
        NotFound,
        Loading
    },
    data() {
        return {
            empty: {
                img: '/img/logo/chat.svg',
                title: 'Пусто',
                description: 'Еще никто не оставлял комментарий'
            },
            reviewCount: 0,
            paginate: 1,
            status: true,
            reviews: [],
            statusContinue: false,
            ajaxStatus: true,
        }
    },
    mounted() {
        this.getReviewCount();
        this.getReviews();
    },
    methods: {
        getReviewCount: function() {
            axios.get('/api/review/count/organization/'+this.id)
                .then(response => {
                    this.reviewCount    =   response.data;
                });
        },
        getReviews: function() {
            if (this.ajaxStatus) {
                this.ajaxStatus =   false;
                axios.get('/api/review/list/organization/'+this.id+'/'+this.paginate++)
                    .then(response => {
                        this.status =   false;
                        this.ajaxStatus =   false;
                        let reviews =   response.data.data;

                        if (reviews.length === 15) {

                            this.statusContinue =   true;
                            this.ajaxStatus =   true;
                        } else {
                            this.statusContinue =   false;
                        }
                        this.reviews    =   this.reviews.concat(reviews);
                    }).catch(error => {
                        this.status     =   false;
                    });
            }
        }
    }
}
</script>

<style lang="scss">
    .btn-scroll {
        margin: 0 auto 0 auto;
        display: block;
        height: 40px;
        background: #00a082;
        border: none;
        color: #fff;
        padding: 0 20px 0 20px;
        border-radius: 30px;
        font-size: 14px;
        outline: none !important;
        box-shadow: none !important;
    }
    @media only screen and (max-width: 768px) {
        .btn-scroll {
            font-size: 11px;
            height: 30px;
            padding: 0 10px 0 10px;
        }
    }
</style>
