
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


import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import OrdersIndex from './components/orders/OrdersIndex.vue';
import OrdersCreate from './components/orders/OrdersCreate.vue';
import OrdersEdit from './components/orders/OrdersEdit.vue';
import ShowTemperature from './components/temperature/ShowTemperature.vue';

const routes = [
    {
        path: '/',
        components: {
            ordersIndex: OrdersIndex
        }
    },
    {path: '/orders/create', component: OrdersCreate, name: 'createOrder'},
    {path: '/orders/edit/:id', component: OrdersEdit, name: 'editOrder'},
    {path: '/temperature', component: ShowTemperature, name: 'createOrder'},
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')

