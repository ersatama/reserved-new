<template>
    <div class="container-fluid">
        <div class="container pt-md-5">
            <div class="col-12 d-flex justify-content-center my-5">
                <div>
                    <img :src="params.img" width="100">
                </div>
            </div>
            <div class="col-12 mt-3 mb-5">
                <h2 class="text-center not-found-title">{{params.title}}</h2>
                <p class="text-center text-secondary mt-2 not-found-description">{{params.description}}</p>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    name: "Not-found",
    props: ['params']
}
</script>

<style lang="scss">
@media only screen and (max-width: 768px) {
    .not {
        &-found {
            &-title {
                font-size: 16px;
            }
            &-description {
                font-size: 12px;
            }
        }
    }
}
</style>
