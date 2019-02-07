
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';
import './material';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import es from 'vee-validate/dist/locale/es';
import VeeValidate, { Validator } from 'vee-validate';
import 'vue-material/dist/vue-material.min.css';

window.Chart = require('chart.js');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
const options = {
    confirmButtonColor: '#000000',
    cancelButtonColor: '#ff7674'
}

Vue.use(VueSweetalert2,options);
Vue.use(VeeValidate);
Validator.localize('es', es);


Vue.component('sidebar-component', require('./components/SidebarComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);
Vue.component('profile-component', require('./components/ProfileComponent.vue').default);
Vue.component('customer-component', require('./components/CustomerComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('order-table-component', require('./components/OrderTableComponent.vue').default);
Vue.component('order-component', require('./components/OrderComponent.vue').default);
Vue.component('report-component', require('./components/ReportComponent.vue').default);
Vue.component('pagination-material-component', require('./components/PaginationComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const dashboard = new Vue({
    el: '#dashboard',
    data: {
        activeMenu: false
    },
    created() {
        this.activeMenu = localStorage.getItem('ativeMenu') ? true:false;
    },
    methods:{
        storeMenu(){
            if(!this.activeMenu){
                this.activeMenu = true;
                localStorage.setItem('ativeMenu','true');
            }else{
                this.activeMenu = false;
                localStorage.removeItem('ativeMenu');
            }
        }
    },
});
