window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

let user    =   sessionStorage.getItem('user');

if (user !== null) {
    user    =   JSON.parse(user);

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'e23697fdbb3e80ef3f02',
        cluster: 'ap2',
        authEndpoint: '/api/user/token/'+user.api_token,
    });
}
