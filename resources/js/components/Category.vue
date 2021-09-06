<template>
    <Header></Header>
    <profile-section :category="category"></profile-section>
    <organization v-if="category" :category="category"></organization>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import Organization from './layout/Organization';

export default {
    name: "Category",
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
        Organization,
    },
    data() {
        return {
            category: false,
        }
    },
    created() {
        this.getCategoryBySlug();
    },
    methods: {
        getCategoryBySlug: function() {
            axios.get('/api/category/slug/'+this.$route.params.category)
                .then(response => {
                    this.category   =   response.data.data;
                });
        },
    }
}
</script>

<style lang="scss">

</style>
