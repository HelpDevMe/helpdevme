/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('PrivateChat', require('./components/chat/private'));
Vue.component('ListChat', require('./components/chat/list'));

Vue.component('CreateQuestion', require('./components/question/create'));
Vue.component('VotesQuestion', require('./components/question/votes'));

import store from './store';
import * as mutations from './store/mutation-types';
import * as actions from './store/action-types';

if (window.user) {
    store.commit(mutations.LOGGED_USER, window.user);
} else {
    store.dispatch(actions.LOGGED_USER);
}

const app = new Vue({
    el: '#app',
    store
});
