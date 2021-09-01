<template>
    <div class="modal fade" id="card_modal" tabindex="-1" role="dialog" aria-labelledby="card_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content auth-modal">
                <div class="modal-body" onselectstart="return false">
                    <div class="form-group d-flex justify-content-end">
                        <button class="auth-btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <template v-if="modal">
                        <div class="form-group">
                            <h3 class="auth-title text-center">Редактирование карты</h3>
                        </div>
                    </template>
                    <template v-else>
                        <div class="form-group">
                            <h3 class="auth-title text-center">Удаление карты</h3>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <p class="text-secondary text-center h6">Вы действительно хотите удалить карту?</p>
                            </div>
                        </div>
                        <div class="col-12 mt-4 mb-2 d-flex">
                            <div class="card-main">
                                <div class="card-main-icon"></div>
                                <div class="card-main-title">
                                    <div class="h5 font-weight-bold">{{card.bank}}</div>
                                    <div class="h6 text-secondary">{{card.hash}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4 mb-2 d-flex" style="gap: 20px;">
                            <div class="w-50">
                                <button class="btn btn-block auth-btn text-white" data-dismiss="modal" aria-label="Close">Отмена</button>
                            </div>
                            <div class=" w-50">
                                <button class="btn btn-block auth-register text-white" @click="deleteModal" data-dismiss="modal" aria-label="Close">Удалить</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['modal','card','index'],
    name: "Card",
    methods: {
        deleteModal: function() {
            this.$emit('delete', this.index);
        }
    }
}
</script>

<style lang="scss">
    .card {
        &-main {
            display: grid;
            grid-template-columns: 44px auto;
            grid-gap: 15px;
            &-icon {
                width: 44px;
                height: 44px;
                background: url(/img/logo/card.svg) no-repeat center;
                background-size: contain;
            }
        }
    }
</style>
