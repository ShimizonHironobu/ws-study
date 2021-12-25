window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

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

//for Echo
import Echo from 'laravel-echo';
window.io = require('socket.io-client');

//接続情報
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: "http://ws-study.tororincho.com"+':6001',
});

//購読するチャネルの設定
// window.Echo.channel('public-event')
//     .listen('.PublicEvent', (e) => {
//         console.log(e);
//     });