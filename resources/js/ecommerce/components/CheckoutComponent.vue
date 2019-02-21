<template>
<div class="container">
    <div class="row checkout">
        <div class="col-12 pb-3" v-if="!order">
            <md-steppers :md-active-step.sync="active" md-linear>
                <md-step id="first" md-label="Información extra" :md-error="errors.first('plus_info')" :md-editable="false" md-description="Opcional" :md-done.sync="first">
                    <p>Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación</p>
                    <md-field v-bind:class="{ 'md-invalid': errors.first('plus_info') }">
                        <label>Información extra</label>
                        <md-textarea v-model="plus_info" data-vv-as="información extra" data-vv-name="plus_info" v-validate="'min:5'" maxlength="500"></md-textarea>
                        <md-icon>description</md-icon>
                        <span class="md-error">{{ errors.first('plus_info') }}</span>
                    </md-field>
                    <md-button class="md-raised md-primary" @click="setDone('first', 'second')" :disabled="errors.first('plus_info') ? true:false">Continuar</md-button>
                </md-step>

                <md-step id="second" md-label="Dirección de envío" :md-error="secondStepError" :md-editable="false" :md-done.sync="second" class="pt-4">
                    <Shipping @next="setDone($event.id,$event.index)"
                    @err="secondStepError = $event"
                    @shippingChange="shippingAmount = $event"
                    @data="shipping = $event"/>
                </md-step>

                <md-step id="third" md-label="Metodo de pago" :md-editable="false" :md-done.sync="third">
                    <ul class="p-0 m-0">
                        <li v-for="payment of payments" :key="payment.id">
                            <md-radio class="md-primary"  v-model="method" :value="payment.id">
                                {{ payment.text_user }}
                            </md-radio>
                        </li>
                    </ul>

                    <md-button class="md-raised md-primary" @click="setDone('third', 'quarter')" :disabled="!completed">Continuar</md-button>
                </md-step>
                <md-step id="quarter" md-label="Finalizar pedido" :md-editable="false" :md-done.sync="quarter" class="pt-4">
                    <div class="row pt-4">
                        <div class="col-md-6">
                            <md-list class="md-double-line">
                                <md-subheader>Metodo de Pago</md-subheader>
                                <md-list-item>
                                    <md-icon class="md-primary">{{methodPayment['md_icon']}}</md-icon>
                                    <div class="md-list-item-text">
                                        <span>{{methodPayment.text_user}}</span>
                                    </div>
                                </md-list-item>
                                <md-divider></md-divider>
                                <md-subheader v-if="shipping">Dirección de envío</md-subheader>
                                <md-list-item v-if="shipping">
                                    <md-icon class="md-primary">location_searching</md-icon>
                                    <div class="md-list-item-text">
                                        <span v-if="shipping.district">{{shipping.district.name}}</span>
                                    </div>
                                </md-list-item>
                            </md-list>
                        </div>

                        <div class="checkout-review-order col-md-6 m-auto">
                            <table class="table_ch">
                                <thead>
                                    <tr>
                                        <th>PRODUCTO</th>
                                        <th class="text-right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="cart_items" v-for="item of products" :key="item.id">
                                        <td class="text_comer_h">{{ item.name+ ' x' + item.quantity }}</td>
                                        <td class="text-right">S/. {{ item.price }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th>SUBTOTAL</th>
                                        <td>
                                            <b class="amount">
                                                S/ {{total}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <th>ENVÍO</th>
                                        <td>
                                            <b class="amount">
                                                S/ {{(shippingAmount).toFixed(2)}}
                                            </b>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>TOTAL</th>
                                        <td>
                                            <span class="amount">
                                                S/{{total + shippingAmount}}
                                            </span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <p>Al hacer tu pedido, aceptas los <a href="/terms_and_conditions" class="font-weight-bold">términos y condiciones</a> de Sis & Comp.</p>
                            <md-button class="md-raised md-primary w-100" :disabled="errors.any() || !completed"  @click="payment()">REALIZAR PEDIDO</md-button>
                        </div>
                    </div>
                </md-step>
            </md-steppers>
        </div>

        <!--<div class="col-md-6 pb-3" v-if="!order">
            <h3><md-icon>local_shipping</md-icon>  DIRECCIÓN DE ENVÍO</h3>
            <md-tabs md-alignment="fixed" @md-changed="shippingChange($event)">
                <md-tab id="tab-store" md-label="Recoger en tienda" md-icon="store">
                    <p> Para recoger tus artículos en Sis & Comp, debes llevar el número de pedido y un
                        documento oficial de entidad con foto.</p>
                        <span class="pt-2">Para mas información lee nuestros <b><a href="/">Terminos de Envio y Entrega</a></b></span>
                </md-tab>
                <md-tab id="tab-location" md-label="Envio a domicilio" md-icon="location_on"></md-tab>
            </md-tabs>
            <h3><md-icon>subtitles</md-icon> MÉTODO DE PAGO</h3>
            <md-radio class="md-primary"  v-model="method"  v-validate="'required'" data-vv-name="card" :value="'card'">Tarjeta de crédito o débito | Visa, Mastercard y más!<br>
                Finalize con su compra para procesar de inmediato su pedido.
            </md-radio>
            <span class="md-error">{{ errors.first('card') }}</span>
            <h3 class="pt-4"><md-icon>description</md-icon> INFORMACIÓN EXTRA</h3>
            <p>Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación</p>
            <md-field v-bind:class="{ 'md-invalid': errors.first('plus_info') }">
                <label>Información extra</label>
                <md-textarea v-model="plus_info" data-vv-as="información extra" data-vv-name="plus_info" v-validate="'min:5'" maxlength="500"></md-textarea>
                <md-icon>description</md-icon>
                <span class="md-error">{{ errors.first('plus_info') }}</span>
            </md-field>
        </div>-->
        <div class="col-12 end-order pb-5" v-if="order">
            <h1>Gracias. Tu pedido ha sido recibido.</h1>
            <ul class="pt-2 pb-3">
                <li>
                    <span>Número de pedido:</span>
                    <strong class="ml-2">{{order.id}}</strong>
                </li>
                <li>
                    <span>Fecha:</span>
                    <strong class="ml-2 text-capitalize">{{order.date}}</strong>
                </li>
                <li>
                    <span>Total:</span>
                    <strong class="ml-2">S/{{total+shippingAmount }}</strong>
                </li>
                <li>
                    <span>Metodo de Pago:</span>
                    <strong class="ml-2">{{ this.methodPayment.name }}</strong>
                </li>
            </ul>
            <h3>Pedido detalle</h3>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item of products" :key="item.id">
                        <td>{{`${item.name} x ${item.quantity}`}}</td>
                        <td class="text-right">S/{{ (item.price * item.quantity).toFixed(2) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="cart-subtotal font-weight-bold">
                        <td>Subtotal:</td>
                        <td class="text-right">S/{{total}}</td>
                    </tr>
                    <tr class="payment-method font-weight-bold">
                        <td>Metododo de Pago:</td>
                        <td class="text-right">{{ this.methodPayment.name }}</td>
                    </tr>
                    <tr class="cart-subtotal font-weight-bold">
                        <td>Envío:</td>
                        <td class="text-right">S/ {{(shippingAmount).toFixed(2)}}</td>
                    </tr>
                    <tr class="order-total font-weight-bold">
                        <td>Total:</td>
                        <td class="text-right total">S/ {{total+shippingAmount}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import Shipping from './ShippingComponent';

export default {
    props: ['products','total','culqui','token','payments'],
    data: () => ({
        plus_info: null,
        method: false,
        order: null,
        errToken: false,
        shippingAmount: 0,
        active: 'first',
        first: false,
        second: false,
        third: false,
        quarter: false,
        secondStepError: null,
        shipping: null,
        methodPayment: Object
    }),mounted() {
        Culqi.publicKey = this.culqui;
        Culqi.options({
            style: {
                logo: 'https://i.ibb.co/ZhkmD14/logo-siscomp.png'
            }
        });
        Culqi.settings({
			title: 'SIS & COMP',
			currency: 'PEN',
			description: 'Lo mejor en equipos de computo y accesorios',
			amount: (this.total *100).toFixed(2)
        });
    },
    components: {Shipping},
    methods: {
        openCulqui(){
            this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
            this.$swal.showLoading();
            this.$validator.validateAll().then((result) => {
                if (result && this.token && !this.errToken) {
                    axios.post('/checkout', {
                        token: this.token,
                        plus_info: this.plus_info,
                        method: this.method,
                        shipping: this.shipping
                    }).then(response => {
                        this.$swal.hideLoading();
                        this.$swal.close();
                        this.order = response.data.data;
                        this.$emit('count',0);
                    }).catch(err => {
                        this.$swal.hideLoading();
                        if(err.response.status == 422){
                            this.$swal.fire(
                                'Opps...',
                                err.response.data.user_message,
                                'error'
                            );
                            this.errToken = true;
                        }else{
                            this.$swal.fire(
                                'Opps...',
                                'Algo salio mal',
                                'error'
                            );
                        }
                    });
                }else if(this.errToken){
                    this.checkMethod();
                }else if(!this.token){
                    this.checkMethod();
                }
            });
        },
        checkMethod(){
            this.$swal.hideLoading();
            this.$swal.close();
            Culqi.open();
        },
        setDone (id, index) {
            this[id] = true
            this.secondStepError = null
            if (index) {
                this.active = index
            }
        },
        payment(){
            switch(this.method){
                case 1:
                    this.openCulqui();
                break;
                case 2:
                     this.paymentDelivery();
                break;
            }
        },paymentDelivery(){
            this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
            this.$swal.showLoading();
            axios.post('/checkout', {
                plus_info: this.plus_info,
                method: this.method,
                shipping: this.shipping
            }).then(response => {
                console.log(response.data);
                this.$swal.hideLoading();
                this.$swal.close();
                this.order = response.data.data;
                this.$emit('count',0);
            }).catch(err => {
                this.$swal.hideLoading();
                this.$swal.fire(
                    'Opps...',
                    'Algo salio mal',
                    'error'
                );
            });
        }
    },computed :{
        completed(){
            return this.method;
        }
    },watch :{
        token(){
            this.openCulqui();
            this.errToken = false;
        },method(){
           this.methodPayment =  this.payments.find(x => x.id === this.method);
        }
    }
};
</script>

