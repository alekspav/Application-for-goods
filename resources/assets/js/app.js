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

import WelcomeIndex from './components/WelcomeIndex.vue';

import ShowTemperature from './components/temperature/ShowTemperature.vue';


import OrderTabsIndex from './components/orders/tabs/OrderTabsIndex.vue';
import OrdersIndex from './components/orders/pages/OrdersIndex.vue';
import OrdersCreate from './components/orders/forms/OrdersCreate.vue';
import OrdersEdit from './components/orders/forms/OrdersEdit.vue';


import ProductsIndex from './components/products/pages/ProductsIndex.vue';
import ProductsCreate from './components/products/forms/ProductsCreate.vue';
import ProductsEdit from './components/products/forms/ProductsEdit.vue';

//Маршруты
const routes = [
    {
        path: '/',
        components: {
            ordersIndex: WelcomeIndex
        }
    },

    {path: '/scoped_orders', component: OrderTabsIndex, name: 'indexScopedOrder'},
    {path: '/orders', component: OrdersIndex, name: 'indexOrder'},
    {path: '/orders/create', component: OrdersCreate, name: 'createOrder', props: true},
    {path: '/orders/edit/:id', component: OrdersEdit, name: 'editOrder', props: true},

    {path: '/temperature', component: ShowTemperature, name: 'temperature'},

    {path: '/products', component: ProductsIndex, name: 'indexProduct'},
    {path: '/products/create', component: ProductsCreate, name: 'createProduct'},
    {path: '/products/edit/:id', component: ProductsEdit, name: 'editProduct'},
]


const router = new VueRouter({routes})

const app = new Vue({router}).$mount('#app')

