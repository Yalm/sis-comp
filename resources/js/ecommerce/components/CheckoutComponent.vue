<template>
<div class="container">
    <div class="row checkout">
        <div class="col-md-6">
            <h2>INFORMACIÓN EXTRA</h2>
            <p>Si desea dejarnos un comentario acerca de su pedido, por favor, escríbalo a continuación</p>
            <md-field v-bind:class="{ 'md-invalid': errors.first('plus_info') }">
                <label>Información extra</label>
                <md-textarea v-model="plus_info" data-vv-as="información extra" data-vv-name="plus_info" v-validate="'min:5'" maxlength="500"></md-textarea>
                <md-icon>description</md-icon>
                <span class="md-error">{{ errors.first('plus_info') }}</span>
            </md-field>
            <h2>MÉTODO DE PAGO</h2>
            <md-radio class="md-primary"  v-model="card"  v-validate="'required'" data-vv-name="card">Tarjeta de crédito o débito | Visa, Mastercard y más!<br>
                Finalize con su compra para procesar de inmediato su pedido.
            </md-radio>
            <span class="md-error">{{ errors.first('card') }}</span>

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
                <md-checkbox v-model="terms" data-vv-name="terms" v-validate="'required'" class="md-primary mt-0">He leído y estoy de acuerdo con los <a href="/terms_and_conditions" class="hover_ch">términos y condiciones</a> de la web</md-checkbox>
                <span class="help text-danger" v-show="errors.has('terms')">{{ errors.first('terms') }}</span>
                <md-button class="md-raised md-primary w-100" :disabled="errors.any() || !completed"  @click="openCulqui()">REALIZAR PEDIDO</md-button>
            </div>
        </div>
    </div>
</div>
</template>

<script>

export default {
    props: ['products','total','culqui','token'],
    data: () => ({
        plus_info: null,
        card:false,
        terms:false,
        errToken: false
    }),mounted() {
        Culqi.publicKey = this.culqui;
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
                if (result && this.token && !this.errToken) {
                    axios.post('/checkout', {
                        token: this.token,
                        plus_info: this.plus_info
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
                            confirmButtonText:'<a class="text-white" href="/profile/orders">Ir a mis pedidos</a>',
                        });
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
            return this.card && this.terms;
        }
    },watch :{
        token(){
            this.openCulqui();
            this.errToken = false;
        }
    }
};
</script>

