require('./bootstrap');

import { createApp } from 'vue';

import Notifications from '@kyvg/vue3-notification';
import App from './app/App';
import router from './router/router';
import Maska from 'maska';
import ReactiveStorage from "vue-reactive-localstorage";
import VueSnip from 'vue-snip';

const app = createApp(App).use(router);

app.use(Maska);
app.use(Notifications);
app.use(VueSnip);

let storage =   {
    token: '',
    user: '',
    auth: true,
    modal: false,
    favorite: [],
    city: '',
    notifications: [],
    booking: '',
    sidebar: {
        show: false,
        view: 0,
        notifications: 0,
    }
};

app.use(ReactiveStorage, storage);

app.mount('#app');
