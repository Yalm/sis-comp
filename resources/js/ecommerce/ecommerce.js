
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';
import './material';
import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import router from './router';
import es from 'vee-validate/dist/locale/es';
import VeeValidate, { Validator } from 'vee-validate';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
const options = {
    confirmButtonColor: '#222222',
    cancelButtonColor: '#ff7674'
}

Vue.use(VueSweetalert2,options);
Vue.use(VeeValidate);
Validator.localize('es', es);


Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('cart-modal-component', require('./components/CartModalComponent.vue').default);
Vue.component('cart-component', require('./components/CartComponent.vue').default);
Vue.component('checkout-component', require('./components/CheckoutComponent.vue').default);
Vue.component('shop-component', require('./components/ShopComponent.vue').default);
Vue.component('qty-component', require('./components/QtyComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

if(process.browser) {
    window.culqi = function () {
        ecommerce.tokenCulqui = Culqi.token.id;
    };
}
const ecommerce = new Vue({
    el: '#ecommerce',
    router,
    data: {
        count: 0,
        mutableList: [],
        tokenCulqui: null,
        districtP: null
    },
    created() {
        axios.get('/count-cart').then( response => {
            this.count = response.data;
        });
    },methods: {
        getDistrict(){
            axios.get('/json/ubigeo/distritos.json').then(response => {
                const data = response.data['3656'];
                this.districtP = data.find(x => x.id_ubigeo === document.getElementById('district').dataset.value).nombre_ubigeo;
            });
        },
        deleteOrder(id){
            this.$swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, cancelar!'
              }).then((result) => {
                if (result.value) {
                    this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
                    this.$swal.showLoading();
                    axios.delete(`/profile/orders/${id}`).then(() => {
                        const state = document.getElementById(`tdstate${id}`);
                        state.innerHTML = 'Cancelado';
                        state.removeAttribute("class");
                        state.style.color = '#dc3545';
                        document.getElementById(`btn${id}`).remove();

                        this.$swal.hideLoading();
                        this.$swal.fire(
                            'Cancelado',
                            'Su pedido ha sido eliminado.',
                            'success'
                        )
                    }).catch(err => {
                        this.$swal.hideLoading();
                        this.$swal.fire(
                            'Opps...',
                            'Algo salio mal',
                            'error'
                        );
                    });
                }
            });
        }
    }
});
