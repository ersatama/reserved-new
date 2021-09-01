<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid mb-5">
        <div class="container">
            <div class="row my-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center my-5">
                        <div class="card-icon">
                            <img src="/img/logo/card.svg" width="100%">
                        </div>
                    </div>
                    <div class="my-5 text-center h3">
                        Спасибо за платеж. Ваш стол забронирован!
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "../header/Header";
import Footer from "../footer/Footer";
import ProfileSection from '../sections/ProfileSection';
import FooterMenu from '../footerMenu/FooterMenu';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu
    },
    name: "Success"
}
</script>

<style lang="scss">
    .card {
        &-icon {
            width: 100px;
        }
    }
</style>
