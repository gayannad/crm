
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router'
import {Form, HasError, AlertError} from 'vform'
require('./bootstrap');

window.Vue = require('vue');
Vue.use(VueRouter);
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import Swal from 'sweetalert2'
window.Swal = Swal


const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});


window.toast = toast
window.Fire = new Vue();

import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
})


let routes = [
    {path: '/dashboard', component: require('./components/Dashboard.vue').default},
    {path: '/users', component: require('./components/Users.vue').default},
    {path: '/customers', component: require('./components/Customers.vue').default},
    {path: '/email', component: require('./components/Email.vue').default},
    {path: '/profile', component: require('./components/Profile.vue').default},
];

const router = new VueRouter({
    routes // short for `routes: routes`
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
})
