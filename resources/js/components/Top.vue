<template>
    <Header></Header>
    <profile-section></profile-section>

    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
export default {
    components: {
        Header,
        Footer,
        ProfileSection,
    },
    name: "Top"
}
</script>

<style scoped>

</style>
