<template>
    <Header></Header>
    <profile-section></profile-section>
    <favoriteOrganization></favoriteOrganization>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import favoriteOrganization from './layout/favoriteOrganization';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
        favoriteOrganization,
    },
    name: "Favorite",
}
</script>

<style lang="scss">
    @import '../../css/favorite/favorite.scss';
    @import '../../css/organization/list.scss';
</style>
