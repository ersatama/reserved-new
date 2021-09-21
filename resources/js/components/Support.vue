<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mt-5 mx-3 text-center font-weight-bold support-main-title">Справочный центр</h1>
                    <h6 class="mt-3 mb-5 mx-md-5 text-center text-secondary support-main-desc">Добро пожаловать! В разделе "Службы поддержки" вы также можете читать сообщения от Службы поддержки. Кроме того, сюда вы получаете важные сообщения, связанные с вашим аккаунтом.</h6>
                    <div class="support mb-5">
                        <div class="support-item">
                            <div class="support-header">
                                <div class="support-item-icon"></div>
                                <div class="support-item-title">Безопасность</div>
                            </div>
                            <div class="support-body">Наши Нормы и правила призваны создать среду, в которой все могут бронировать места в заведениях.</div>
                        </div>
                        <div class="support-item">
                            <div class="support-header">
                                <div class="support-item-icon"></div>
                                <div class="support-item-title">Бронирование</div>
                            </div>
                            <div class="support-body">Для бронирования стола в заведениях, вам необходимо зайти на страницу заведения, выбрать стол, затем выбрать время на которую вы хотели бы посетить данное заведение</div>
                        </div>
                    </div>
                    <a target="_blank" href="https://wa.me/77052395112?text=Мне%20нужна%20помощь!" class="support-btn">Написать в служббу поддержки</a>
                </div>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import ProfileSection from './sections/ProfileSection';
import Footer from "./footer/Footer";
export default {
    name: "Support",
    components: {
        Header,
        ProfileSection,
        Footer
    }
}
</script>

<style lang="scss">
    .support {
        background: #fff;
        border: 1px solid #e6f1ec;
        border-radius: 10px;
        &-btn {
            background: #57a283;
            color: #fff !important;
            margin: 0 auto 50px auto;
            display: table;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none !important;
            padding: 10px 15px 10px 15px;
        }
        &-item {
            border-bottom: 1px solid #e6f1ec;
            &:last-child {
                border-bottom: none;
            }
            &-title {
                font-size: 20px;
                font-weight: bold;
            }
            &-icon {

            }
        }
        &-header {
            overflow: hidden;
            display: flex;
            margin: 20px;
        }
        &-body {
            margin: 20px;
            color: grey;
        }
    }
    @media only screen and (max-width: 768px) {
        .support {
            &-item {
                &-title {
                    font-size: 16px;
                }
            }
            &-header {
                margin: 15px;
            }
            &-main {
                &-title {
                    font-size: 20px;
                }
                &-desc {
                    font-size: 14px;
                }
            }
            &-body {
                font-size: 12px;
                margin: 15px
            }
        }
    }
</style>
