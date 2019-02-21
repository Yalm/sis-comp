<template>
 <div class="row">
        <div class="page-titles d-flex justify-content-between align-items-center">
            <h5 class="page-title">Actualizar pedido</h5>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a class="text-dark" href="/admin">Inicio</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="/admin/orders">Listado de pedidos</a></li>
                <li class="breadcrumb-item"><span class="text-dark">Actualizar pedido</span></li>
            </ul>
        </div>
        <div class="col-12 p-0">
            <div class="container-fluid">
                <div class="row" v-if="order">
                    <md-card class="col-lg-8 info-product">
                        <md-progress-bar class="md-primary" md-mode="indeterminate" v-if="sending"></md-progress-bar>
                        <md-card-header>
                            <div class="md-title">Datos del pedido</div>
                        </md-card-header>
                        <md-card-content class="form-row">

                            <md-field v-bind:class="{ 'md-invalid': errors.first('id') }">
                                <md-icon>assignment_late</md-icon>
                                <label>Numero de pedido </label>
                                <md-input required type="number" :disabled="true" data-vv-as="numero" v-model="order.id"
                                    v-validate="'required'" data-vv-name="id"></md-input>
                                <span class="md-error">{{ errors.first('id') }}</span>
                            </md-field>
                            <md-field class="mt-1" v-bind:class="{ 'md-invalid': errors.first('plus_info') }">
                                <label>Información extra</label>
                                <md-textarea :disabled="sending" v-model="order.plus_info" data-vv-as="información extra" data-vv-name="plus_info" v-validate="'min:5'"></md-textarea>
                                <md-icon>description</md-icon>
                                <span class="md-error">{{ errors.first('plus_info') }}</span>
                            </md-field>

                            <md-list class="md-double-line w-100 mb-3">
                                <md-subheader>Pago</md-subheader>
                                <md-list-item>
                                    <md-icon class="md-primary">
                                        {{order.payment.payment_type.md_icon}}
                                        <md-tooltip md-direction="top">{{order.payment.payment_type.name}}</md-tooltip>
                                    </md-icon>
                                    <div class="md-list-item-text">
                                        <span v-if="order.payment.reference_code">Codigo de refencia: {{order.payment.reference_code}}</span>
                                        <span v-if="order.payment.reference_code">Fecha: {{order.payment.date}}</span>
                                        <p>{{ order.payment.amount == 0.00 ? 'Falta pagar':`Monto: S/ ${order.payment.amount}` }}</p>
                                        <span v-if="order.payment.amount == 0.00">Total: S/ {{order.total}}</span>
                                    </div>
                                </md-list-item>
                                <md-divider v-if="order.voucher"></md-divider>
                                <md-subheader v-if="order.voucher">Comprobante de pago</md-subheader>
                                <md-list-item v-if="order.voucher">
                                    <md-icon class="md-primary">
                                        description
                                    </md-icon>
                                    <div class="md-list-item-text">
                                        <span>Serie: {{order.voucher.serie}}</span>
                                        <span>Numero: {{order.voucher.number}}</span>
                                    </div>
                                    <md-button class="md-icon-button md-list-action" :href="order.voucher.link" target="_blank">
                                        <md-icon class="md-primary">remove_red_eye</md-icon>
                                    </md-button>
                                </md-list-item>
                            </md-list>
                            <md-table class="w-100">
                                <md-table-toolbar class="pl-1">
                                    <h1 class="md-title">Productos</h1>
                                </md-table-toolbar>

                                <md-table-row>
                                    <md-table-head >Producto</md-table-head>
                                    <md-table-head md-numeric>Cantidad</md-table-head>
                                    <md-table-head md-numeric>Total</md-table-head>
                                </md-table-row>

                                <md-table-row  v-for="product of order.products" :key="product.id">
                                    <md-table-cell class="let">{{product.name}}</md-table-cell>
                                    <md-table-cell md-numeric>{{product.pivot.quantity}}</md-table-cell>
                                    <md-table-cell md-numeric>S/ {{ (product.pivot.quantity * product.price).toFixed(2) }}</md-table-cell>
                                </md-table-row>
                            </md-table>
                        </md-card-content>
                        <md-card-actions>
                            <md-button href="/admin/orders" :disabled="sending">Atras</md-button>
                            <md-button class="md-raised md-primary" :disabled="sending ||errors.any()" @click="update()">Actualizar</md-button>
                        </md-card-actions>
                    </md-card>
                    <div class="col-lg-4 list-plus">
                        <md-list :md-expand-single="true" class="pt-0 pb-0">
                            <md-list-item md-expand :md-expanded="true">
                                <md-icon>style</md-icon>
                                <span class="md-list-item-text">Estados de pedido</span>

                                <md-list slot="md-expand" class="pl-3 pr-3">
                                    <md-field v-bind:class="{ 'md-invalid': errors.first('state_id') }">
                                        <md-icon>local_offer</md-icon>
                                        <label for="state_id">Estado</label>
                                        <md-select name="state_id" id="state_id"
                                            data-vv-as="estados" data-vv-name="estado" v-validate="'required'" v-model="order.state_id" :disabled="sending">
                                            <md-option v-for="state of states" :key="state.id" :value="state.id">{{state.name}}</md-option>
                                        </md-select>
                                        <span class="md-error">@{{ errors.first('state_id') }}</span>
                                    </md-field>
                                </md-list>
                            </md-list-item>
                            <md-list-item md-expand>
                                <md-icon>local_shipping</md-icon>
                                <span class="md-list-item-text">Envio</span>

                                <md-list slot="md-expand" class="pl-3 pr-3">
                                    <md-field v-bind:class="{ 'md-invalid': errors.first('district') }" v-if="order.shipping">
                                        <md-icon>local_offer</md-icon>
                                        <label for="district_id">Distritos</label>
                                        <md-select name="district_id" id="district_id"
                                            data-vv-as="distritos" data-vv-name="district" v-validate="'required'" v-model="order.shipping.district_id" :disabled="true">
                                            <md-option v-for="district of districs" :key="district.id_ubigeo" :value="district.id_ubigeo">{{district.nombre_ubigeo}}</md-option>
                                        </md-select>
                                        <span class="md-error">@{{ errors.first('district') }}</span>
                                    </md-field>
                                    <md-field v-bind:class="{ 'md-invalid': errors.first('address') }" v-if="order.shipping">
                                        <md-icon>location_on</md-icon>
                                        <label>Dirección</label>
                                        <md-input v-model="order.shipping.address" data-vv-as="dirección" data-vv-name="address" :disabled="true" v-validate="'required|min:5'" maxlength="191"></md-input>
                                            <span class="md-error">{{ errors.first('address') }}</span>
                                    </md-field>
                                    <div v-if="!order.shipping" class="pt-2 pb-2">
                                        <md-icon>store</md-icon> Recoger en tienda
                                    </div>
                                </md-list>
                            </md-list-item>
                            <md-list-item md-expand>
                                <md-icon>account_box</md-icon>
                                <span class="md-list-item-text">Cliente</span>
                                <md-list slot="md-expand" class="pl-3 pr-3">
                                    <md-list-item>
                                        <md-avatar>
                                            <img src="/img/default-avatar.png" alt="People">
                                        </md-avatar>
                                        <div class="md-list-item-text">
                                            <span>{{order.customer.name}}</span>
                                            <span>{{order.customer.surnames}}</span>
                                            <p>{{order.customer.email}}</p>
                                        </div>

                                        <md-button class="md-icon-button md-list-action" :href="`/admin/customers/${order.customer.id}?order=${order.id}`">
                                            <md-icon class="md-primary">remove_red_eye</md-icon>
                                        </md-button>
                                    </md-list-item>
                                </md-list>
                            </md-list-item>
                        </md-list>
                    </div>
                </div>
            </div>
        </div>
        <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="showSnackbar" md-persistent>
            <span>Exito. Se actualizo su pedido!</span>
            <md-button class="md-primary">Ok</md-button>
        </md-snackbar>
    </div>
</template>
<script>
export default {
    props:['orderp','states'],
    data: () => ({
        sending: false,
        order: null,
        showSnackbar: false,
        districs: Array
    }),mounted(){
        this.order = this.orderp;
        axios.get('/json/ubigeo/distritos.json').then(responseDistricts => {
            this.districs = responseDistricts.data['3656'];
        });
    },methods: {
        update(){
            this.sending = true;
            axios.put(`/admin/orders/${this.order.id}`,this.order).then(response=>{
                this.showSnackbar = true;
                this.sending = false;
                this.order = response.data;
            }).catch(err => {
                if(err.response.status == 422){
                    for(const error in err.response.data.errors){
                        this.$validator.errors.add({
                            field: error,
                            msg: err.response.data.errors[error][0]
                        });
                    }
                }else if(err.response.status == 409){
                    this.$swal.fire(
                        'Opps...',
                        err.response.data.message,
                        'error'
                    );
                }else{
                    this.$swal.fire(
                        'Opps...',
                        'Algo salio mal',
                        'error'
                    );
                }
                this.sending = false;
            });
        }
    }
}
</script>
