<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mt-5 mx-3 text-center font-weight-bold">Справочный центр</h1>
                    <h6 class="mt-3 mb-5 mx-5 text-center text-secondary">Добро пожаловать! В разделе "Службы поддержки" вы также можете читать сообщения от Службы поддержки. Кроме того, сюда вы получаете важные сообщения, связанные с вашим аккаунтом.</h6>
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
                            <div class="support-body">Для бронирования стола в заведениях, вам необходимо зайти на страницу заведения, выбрать стол, затем выбрать время на кторую вы хотели бы посетить данное заведение</div>
                        </div>
                        <div class="support-item">
                            <div class="support-header">
                                <div class="support-item-icon"></div>
                                <div class="support-item-title">Lorem ipsum dolor sit amet</div>
                            </div>
                            <div class="support-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import Footer from "./footer/Footer";
export default {
    name: "Support",
    components: {
        Header,
        ProfileSection,
        FooterMenu,
        Footer
    }
}
</script>

<style lang="scss">
    .support {
        background: #fff;
        border: 1px solid #e6f1ec;
        border-radius: 10px;
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
        }
    }
</style>
