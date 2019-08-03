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

import store from './store';
import BootstrapVue from 'bootstrap-vue';
import VueCurrencyFilter from 'vue-currency-filter';
import Vue2Editor from 'vue2-editor';

Vue.use(Vue2Editor);

Vue.use(BootstrapVue);

Vue.use(VueCurrencyFilter, {
	symbol: 'R$',
	thousandsSeparator: '.',
	fractionCount: 2,
	fractionSeparator: ',',
	symbolPosition: 'front',
	symbolSpacing: true
});

Vue.prototype.$userId = document
	.querySelector("meta[name='user-id']")
	.getAttribute('content');

Vue.component('PrivateChat', require('./components/chat'));
Vue.component('ListChat', require('./components/chat/list'));

Vue.component('CreateQuestion', require('./components/question/create'));
Vue.component('VotesQuestion', require('./components/question/votes'));

Vue.component('ListNewQuestions', require('./components/question/list'));

Vue.component('CComments', require('./components/comments'));

const app = new Vue({
	store,
	el: '#app'
});
