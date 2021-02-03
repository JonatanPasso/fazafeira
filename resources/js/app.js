require('./bootstrap');
require('datatables.net-dt');
require('datatables.net-responsive-dt');

import Vue from 'vue';
import money from 'v-money';
import VueRouter from 'vue-router';
import routes from './routes';
import VueNotification from "vue-notification";


var VueScrollTo = require('vue-scrollto');

Vue.use(VueRouter);
Vue.use(money, {precision: 2});
Vue.use(VueScrollTo);
Vue.use(VueNotification);

Vue.use(require('vue-moment'));

const router = new VueRouter({routes});

const app = new Vue({
    router,
    el: '#app',
});
