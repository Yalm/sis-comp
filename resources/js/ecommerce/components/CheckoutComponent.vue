<template>
<div class="container">
    <div class="row checkout">
        <div class="col-md-6" v-if="!order">
            <h2>INFORMACIÓN EXTRA</h2>
            <p>Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación</p>
            <md-field v-bind:class="{ 'md-invalid': errors.first('plus_info') }">
                <label>Información extra</label>
                <md-textarea v-model="plus_info" data-vv-as="información extra" data-vv-name="plus_info" v-validate="'min:5'" maxlength="500"></md-textarea>
                <md-icon>description</md-icon>
                <span class="md-error">{{ errors.first('plus_info') }}</span>
            </md-field>
            <h2>MÉTODO DE PAGO</h2>
            <md-radio class="md-primary"  v-model="method"  v-validate="'required'" data-vv-name="card" :value="'card'">Tarjeta de crédito o débito | Visa, Mastercard y más!<br>
                Finalize con su compra para procesar de inmediato su pedido.
            </md-radio>
            <span class="md-error">{{ errors.first('card') }}</span>

        </div>
        <div class="col-md-6" v-if="!order">
            <div class="checkout-review-order">
                <table class="table_ch cl5">
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
                                    S/{{total}}
                                </b>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>TOTAL</th>
                            <td>
                                <span class="amount">
                                    S/.{{total}}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <md-checkbox v-model="terms" data-vv-name="terms" v-validate="'required'" class="md-primary mt-0">He leído y estoy de acuerdo con los <a href="/terms_and_conditions" class="hover_ch">términos y condiciones</a> de la web</md-checkbox>
                <span class="help text-danger" v-show="errors.has('terms')">{{ errors.first('terms') }}</span>
                <md-button class="md-raised md-primary w-100" :disabled="errors.any() || !completed"  @click="openCulqui()">REALIZAR PEDIDO</md-button>
            </div>
        </div>
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
                    <strong class="ml-2">S/{{total}}</strong>
                </li>
                <li>
                    <span>Metodo de Pago:</span>
                    <strong class="ml-2">{{ this.method == 'card' ? 'Tarjeta de crédito': 'Déposito bancario' }}</strong>
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
                        <td class="text-right">{{ this.method == 'card' ? 'Tarjeta de crédito': 'Déposito bancario' }}</td>
                    </tr>
                    <tr class="order-total font-weight-bold">
                        <td>Total:</td>
                        <td class="text-right total">S/{{total}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</template>

<script>

export default {
    props: ['products','total','culqui','token'],
    data: () => ({
        plus_info: null,
        method: false,
        terms:false,
        order: null,
        errToken: false
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
			amount: this.total *100
        });
    },
    methods: {
        openCulqui(){
            this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
            this.$swal.showLoading();
            this.$validator.validateAll().then((result) => {
                if (result && this.token && !this.errToken) {
                    axios.post('/checkout', {
                        token: this.token,
                        plus_info: this.plus_info,
                        method: this.method
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
        }
    },computed :{
        completed(){
            return this.method && this.terms;
        }
    },watch :{
        token(){
            this.openCulqui();
            this.errToken = false;
        }
    }
};
</script>

