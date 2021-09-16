<template>
    <Header></Header>
    <profile-section></profile-section>
    <div class="container-fluid p-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mt-5 mx-3 text-center font-weight-bold support-main-title">Контакты</h1>
                    <h6 class="mt-3 mb-5 mx-md-5 text-center text-secondary support-main-desc">Добро пожаловать! В разделе "Службы поддержки" вы также можете читать сообщения от Службы поддержки. Кроме того, сюда вы получаете важные сообщения, связанные с вашим аккаунтом.</h6>
                    <div class="contacts">
                        <div class="contacts-main">
                            <div class="contacts-item">
                                <div class="contacts-icon contacts-icon-phone"></div>
                                <a href="tel:+77052395112" class="contacts-title">+77052395112</a>
                            </div>
                            <div class="contacts-item">
                                <div class="contacts-icon contacts-icon-email"></div>
                                <a href="mailto:antechnology@bk.ru" class="contacts-title">antechnology@bk.ru</a>
                            </div>
                            <div class="contacts-item">
                                <div class="contacts-icon contacts-icon-whatsapp"></div>
                                <a  target="_blank" href="https://wa.me/77052395112?text=Здравствуйте!" class="contacts-title">+77052395112</a>
                            </div>
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
    name: "Contacts",
    components: {
        Header,
        ProfileSection,
        FooterMenu,
        Footer
    }
}
</script>

<style lang="scss">
    .contacts {
        margin: 0 0 50px 0;
        &-main {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e6f1ec;
        }
        &-item {
            border-bottom: 1px solid #e6f1ec;
            display: flex;
            padding: 20px;
            gap: 20px;
            align-items: center;
            &:last-child {
                border-bottom: none;
            }
        }
        &-icon {
            height: 30px;
            width: 30px;
            background: no-repeat center;
            background-size: contain;
            &-email {
                background-image: url('/img/logo/envelope.png');
            }
            &-phone {
                background-image: url('/img/logo/call.png');
            }
            &-whatsapp {
                background-image: url('/img/logo/whatsapp.png');
            }
        }
        &-title {
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            color: #000 !important;
            text-decoration: none !important;
            padding: 0;
        }
    }
    @media only screen and (max-width: 768px) {
        .contacts {
            &-icon {
                width: 20px;
                height: 20px;
            }
            &-title {
                font-size: 12px;
            }
        }
    }
</style>
