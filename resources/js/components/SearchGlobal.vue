<template>
    <Header></Header>
    <profile-section></profile-section>
    <template v-if="$route.query.tag">
        <div class="container-fluid">
            <div class="container">
                <div class="search-tag-main-title">{{$route.query.tag}}</div>
            </div>
        </div>
        <SearchOrganization></SearchOrganization>
    </template>
    <template v-else>
        <Search></Search>
        <div class="container-fluid">
            <div class="container">
                <div class="search-tag-global">
                    <div class="search-tag-icon"></div>
                    <div class="search-tag-title">Поиск заведении</div>
                </div>
            </div>
        </div>
    </template>
    <Footer-menu></Footer-menu>
    <Footer></Footer>
</template>

<script>
import Header from "./header/Header";
import Footer from "./footer/Footer";
import ProfileSection from './sections/ProfileSection';
import FooterMenu from './footerMenu/FooterMenu';
import Search from './layout/Search';
import SearchOrganization from './layout/searchOrganization';
export default {
    name: "SearchGlobal",
    components: {
        Header,
        Footer,
        FooterMenu,
        ProfileSection,
        Search,
        SearchOrganization
    },
}
</script>

<style lang="scss">
    .search-tag {
        &-global {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 100px 0 100px 0;
            gap: 10px;
        }
        &-title {
            font-size: 20px;
            padding: 0;
            color: #57a283;
        }
        &-icon {
            width: 50px;
            height: 50px;
            background: url('/img/logo/search.png') no-repeat center;
        }
        &-main {
            &-title {
                font-size: 30px;
                margin: 20px 0 20px 0;
            }
        }
    }
</style>
