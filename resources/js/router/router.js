import { createWebHistory, createRouter } from "vue-router";

import Main from "../components/Main";

import Profile from "../components/Profile";
import Settings from "../components/Settings";
import Payments from "../components/Payments";
import History from "../components/History";

import Favorite from "../components/Favorite";

import News from "../components/News";

import Home from "../components/Home";
import Category from '../components/Category';

import Organization from '../components/Organization';
import CardSuccess from '../components/Card/Success';
import Form from '../components/Form';
const routes = [
    {
        path: "/",
        name: "Main",
        component: Main,
    },
    {
        path: "/card/success",
        name: "CardSuccess",
        component: CardSuccess,
    },
    {
        path: '/home',
        name: 'Home',
        component: Home
    },
    {
        path: '/home/:category',
        name: 'Category',
        component: Category
    },
    {
        path: '/home/:category/:id',
        name: 'Organization',
        component: Organization
    },
    {
        path: '/news',
        name: 'News',
        component: News
    },
    {
        path: '/favorite',
        name: 'Favorite',
        component: Favorite
    },
    {
        path: '/form',
        name: 'Form',
        component: Form
    },
    {
        path: '/profile',
        name: 'Profile',
        component: Profile
    },
    {
        path: '/profile/settings',
        name: 'Profile/Settings',
        component: Settings
    },
    {
        path: '/profile/payments',
        name: 'Profile/Payments',
        component: Payments
    },
    {
        path: '/profile/history',
        name: 'Profile/History',
        component: History
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
