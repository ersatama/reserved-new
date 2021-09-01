<template>
    <Header></Header>
    <profile-section :category="category"></profile-section>
    <loading v-if="Loading"></loading>
    <organization v-else-if="organizations.length > 0" :organizations="organizations" :category="category"></organization>
    <not-found v-else :params="NotFound"></not-found>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import NotFound from './layout/Not-found';
import Loading from './layout/Loading';
import Organization from './layout/Organization';
export default {
    name: "Category",
    components: {
        Header,
        Footer,
        ProfileSection,
        FooterMenu,
        NotFound,
        Organization,
        Loading
    },
    data() {
        return {
            Loading: true,
            NotFound: {
                img: '/img/logo/reserved.png',
                title: 'Категория не найдено',
                description: 'Возможно категория которую вы искали называется иначе.'
            },
            city: 1,
            category: false,
            organizations: [],
        }
    },
    created() {
        this.setFilter();
        this.getCategoryBySlug();
    },
    methods: {
        setFilter: function() {
            if (this.storage.city) {
                this.city =   this.storage.city.id;
            }
        },
        getCategoryBySlug: function() {
            axios.get('/api/category/slug/'+this.$route.params.category)
                .then(response => {
                    this.category   =   response.data.data;
                    this.getOrganizationsByCategoryId();
                });
        },
        getOrganizationsByCategoryId: function() {
            if (this.category) {
                axios.get('/api/category/organizations/'+this.category.id+'/'+this.city)
                    .then(response => {
                        let data    =   response.data.data;
                        for (let i = 0; i < data.length; i++) {
                            data[i].timeTitle   =   this.getTime(data[i]);
                        }
                        this.organizations    =   data;
                        this.Loading    =   false;
                    }).catch(error => {
                        this.Loading    =   false;
                    });
            }
        },
        getTime: function(organization) {
            let today   =   new Date();
            today       =   new Date(today.getFullYear(),today.getMonth(),today.getDate());
            let weekDay =   today.getDay();
            let week;
            if (weekDay === 0) {
                week    =   organization.sunday;
            } else if (weekDay === 1) {
                week    =   organization.monday;
            } else if (weekDay === 2) {
                week    =   organization.tuesday;
            } else if (weekDay === 3) {
                week    =   organization.wednesday;
            } else if (weekDay === 4) {
                week    =   organization.thursday;
            } else if (weekDay === 5) {
                week    =   organization.friday;
            } else if (weekDay === 6) {
                week    =   organization.saturday;
            }
            if (week.start === week.end) {
                return 'круглосуточно';
            }
            return 'c '+this.timeConvert(week.start)+' до '+this.timeConvert(week.end);
        },
        timeConvert: function(time) {
            let converted   =   time.split(':');
            return converted[0]+':'+converted[1];
        },
    }
}
</script>

<style lang="scss">

</style>
