<template>
<div class="container">
    <div class="row checkout">
        <div class="col-md-6">
            <h2>INFORMACIÓN EXTRA</h2>
            <p>Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación</p>
            <div class="form-group from-siscom">
                <textarea class="form-control input-siscom" id="exampleFormControlTextarea1" rows="5" name="plus_info"></textarea>
                <span class="focus-border" v-show="!errors.first('plus_info')">
                    <i></i>
                </span>
                <span class="invalid-feedback" role="alert" v-show="errors.has('plus_info')">
                    <strong>@{{ errors.first('plus_info') }}</strong>
                </span>
            </div>
            <h2>MÉTODO DE PAGO</h2>
            <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" name="tarjeta" class="custom-control-input" v-validate="'required'" @click="checkMethod()">
                <label class="custom-control-label" for="customRadio1">Tarjeta de crédito o débito | Visa, Mastercard y más!</label>
                <p class="text-help-method">Finalize con su compra para procesar de inmediato su pedido.</p>
                <span class="help text-danger" v-show="errors.has('tarjeta')">{{ errors.first('tarjeta') }}</span>
            </div>
        </div>
        <div class="col-md-6">
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
                <div class="custom-control custom-checkbox check-p">
                    <input type="checkbox" class="custom-control-input" id="terms" name="terms" v-validate="'required'">
                    <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los <a href="/terms_and_conditions" class="hover_ch">términos y condiciones</a> de la web</label>
                    <span class="help text-danger" v-show="errors.has('terms')">{{ errors.first('terms') }}</span>
                </div>

                <button type="button" :disabled="errors.any()"  v-on:click="openCulqui()" id="payment_sucess" class="btn-siscom text-center check">
                    REALIZAR PEDIDO
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
if(process.browser) {
    window.culqi = function () {
        window.__culqi_token = Culqi.token;
    };
}
export default {
    props: ['products','total'],
    data(){
        return {
            disableButton: false
        }
    },
    mounted() {
        Culqi.publicKey = 'pk_test_wvFSgWHdepztNJFh';
        Culqi.settings({
			title: 'SIS & COMP',
			currency: 'PEN',
			description: 'Lo mejor en equipos de computo y accesorios',
			amount: this.total * 100
        });
    },
    methods: {
        openCulqui(){
            this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
            this.$swal.showLoading();
            this.$validator.validateAll().then((result) => {
                if (result && window.__culqi_token) {
                    axios.post('/checkout', {
                        token: window.__culqi_token.id
                    }).then(response => {
                        this.$swal.hideLoading();
                        this.$swal.fire({
                            title: 'Orden completa',
                            type: 'success',
                            html:
                                'Revise su perfil para ver su ' +
                                '<a href="/profile/orders">pedido</a> ',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            confirmButtonText:'<a href="/profile/orders">Ir a mis pedidos</a>',
                        });
                    }).catch(err => {
                        this.$swal.hideLoading();
                        this.$swal.fire(
                            'Opps...',
                            'Algo salio mal',
                            'error'
                            );
                        window.__culqi_token = null;
                    });
                }else if(!window.__culqi_token){
                    this.$swal.hideLoading();
                    this.$swal.close();
                    Culqi.open();
                    this.createToken().then(data=>{
                        this.openCulqui();
                    });
                }
            });
        },
        checkMethod(){
            Culqi.open();
            this.disableButton = true;
        },
        createToken () {
            return new Promise(resolve => {
                setInterval(() => {
                    if (window.__culqi_token) {
                        resolve(__culqi_token);
                    }
                }, 1000);
            })
        }
    }
};
</script>
