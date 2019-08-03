import Vue from 'vue';
import Vuex from 'vuex';

import questions from './components/question/store';

Vue.use(Vuex);

const modules = {
	questions
};

export default new Vuex.Store({
	strict: process.env.NODE_ENV !== 'production',
	modules
});
