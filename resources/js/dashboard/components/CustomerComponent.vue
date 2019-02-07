<template>
<div>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title text-capitalize">Clientes</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input placeholder="Buscar por nombre..." aria-label="Buscar por nombre..." v-model="search" @input="searchOnTable" />
            </md-field>
        </md-table-toolbar>

        <md-table-empty-state
            md-label="No se encontraron clientes"
            :md-description="`Ningúna cliente encontrado para esta '${search}' consulta. Intente un término de búsqueda diferente o cree un nuevo cliente.`">
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell md-label="Nombre" md-sort-by="name">{{ item.name }}</md-table-cell>
            <md-table-cell md-label="Apellidos" md-sort-by="surnames">{{ item.surnames }}</md-table-cell>
            <md-table-cell md-label="Correo" md-sort-by="email">{{ item.email }}</md-table-cell>
            <md-table-cell md-label="Compras" md-sort-by="shop" md-numeric>{{ item.shop }}</md-table-cell>
            <md-table-cell md-label="Acciones">
                <md-button @click="edit(item)" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                <md-button class="md-icon-button" @click="deleteItem(item)"><md-icon>delete</md-icon></md-button>
            </md-table-cell>
        </md-table-row>
    </md-table>
    <md-dialog :md-active.sync="activeDialog" :md-close-on-esc="!sending" :md-click-outside-to-close="!sending" @md-closed="closeDialog()">
        <md-progress-bar class="md-primary" md-mode="indeterminate" v-if="sending"></md-progress-bar>
        <md-dialog-title>Editar cliente</md-dialog-title>
        <md-dialog-content class="row content-dialog" v-if="customer">
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('name') }">
                    <md-icon>face</md-icon>
                    <label>Nombre</label>
                    <md-input v-model="customer.name" required maxlength="191" :disabled="sending" data-vv-as="nombre" data-vv-name="name" v-validate="'required|min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('name') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('surnames') }">
                    <md-icon>face</md-icon>
                    <label>Apellidos</label>
                    <md-input v-model="customer.surnames" maxlength="191" :disabled="sending" data-vv-as="apellidos" data-vv-name="surnames" v-validate="'min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('surnames') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('email') }">
                    <md-icon>email</md-icon>
                    <label>Correo</label>
                    <md-input v-model="customer.email" required maxlength="191" :disabled="sending" data-vv-as="correo" data-vv-name="email" v-validate="'required|email|min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('email') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('password') }">
                    <md-icon>lock</md-icon>
                    <label>Contraseña</label>
                    <md-input v-model="customer.password" maxlength="191" type="password" :disabled="sending" data-vv-as="contraseña" data-vv-name="password" v-validate="'min:6|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('password') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field>
                    <md-icon>account_box</md-icon>
                    <label for="document_id">Documento</label>
                    <md-select v-model="customer.document_id" name="document_id" id="document_id">
                        <md-option v-for="document of documents" :key="document.id" :value="document.id">{{document.name}}</md-option>
                    </md-select>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('document_number') }">
                    <md-icon>ballot</md-icon>
                    <label>Numero de documento</label>
                    <md-input v-model="customer.document_number" maxlength="191" :disabled="sending" data-vv-as="numero de documento" data-vv-name="document_number" v-validate="'min:6|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('document_number') }}</span>
                </md-field>
            </div>
            <div class="col-12">
                <md-field v-bind:class="{ 'md-invalid': errors.first('phone') }">
                    <md-icon>phone</md-icon>
                    <label>Telofono/celular</label>
                    <md-input v-model="customer.phone" maxlength="30" :disabled="sending" data-vv-as="telofono/celular" data-vv-name="phone" v-validate="{ required: true,max:30,min:6 ,regex:/^([0-9\.\s\-\+\(\)]*)$/ }"></md-input>
                    <span class="md-error">{{ errors.first('phone') }}</span>
                </md-field>
            </div>
            <div class="col-12">
                <h6 class="pb-2">Pedidos</h6>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Monto</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order of customer.orders" :key="order.id">
                            <th scope="row">{{order.id}}</th>
                            <td class="text-capitalize">{{ order.state.name}}</td>
                            <td class="text-capitalize">{{ order.date }}</td>
                            <td>S/ {{ order.payment.amount }}</td>
                            <td><md-button :href="`/admin/orders/${order.id}/edit`" class="md-icon-button"><md-icon>edit</md-icon></md-button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button :disabled="sending" class="md-primary" @click="activeDialog = false">Cerrar</md-button>
            <md-button :disabled="sending || errors.any()" class="md-raised md-primary" @click="updated()" >Actualizar cliente</md-button>
        </md-dialog-actions>
    </md-dialog>
    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="showSnackbar" md-persistent>
        <span>{{messageSnackbar}}</span>
        <md-button class="md-primary">Ok</md-button>
    </md-snackbar>
</div>
</template>
<script>
    const toLower = text => {
        return text.toString().toLowerCase()
    }

    const searchByName = (items, term) => {
        if (term) {
            return items.filter(item => toLower(item.name).includes(toLower(term)))
        }
        return items
    }
export default {
    props: ['data'],
    data: () => ({
        search: null,
        searched: [],
        activeDialog: false,
        showSnackbar: false,
        messageSnackbar: '',
        customer: null,
        sending: false,
        documents: null
    }),mounted(){
        //console.dir(this.data);
    },
    methods: {
        searchOnTable (){
            this.searched = searchByName(this.data, this.search)
        },updated(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    this.sending = true;
                    axios.put(`/admin/customers/${this.customer.id}`,this.customer)
                    .then( response => {
                        this.sending = false;
                        this.closeDialog();
                        this.messageSnackbar = 'Exito. Se actualizo su cliente!';
                        this.showSnackbar = true;
                        this.activeDialog = false;
                        const index = this.searched.findIndex((x => x.id == response.data.id));
                        this.searched[index] = response.data;
                    }).catch(err => {
                        if(err.response.status == 422){
                            console.log(err.response);
                        }
                        this.sending = false;
                    });;
                }
            });
        },
        store(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    axios.post('/admin/categories',{name:this.category.name}).then( response => {
                        this.sending = false;
                        this.closeDialog();
                        this.messageSnackbar = 'Exito. Se creo una nueva categoría!';
                        this.showSnackbar = true;
                        this.activeDialog = false;
                       this.searched.push(response.data);
                    }).catch(err => {
                        if(err.response.status == 422){
                            this.$validator.errors.add({
                                field: 'category',
                                msg: err.response.data.errors.name[0]
                            });
                        }
                        this.sending = false;
                    });
                }
            });
        },
        edit(item){
            this.activeDialog = true;
            axios.get(`/admin/customers/${item.id}?json=true`).then(response => {
                this.customer = response.data.customer;
                this.documents = response.data.documents;
            });
        },deleteItem(item){
            this.$swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: 'No, cancela!',
                reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        this.$swal({title:'Espera por favor...',allowEscapeKey: false,allowOutsideClick: false});
                        this.$swal.showLoading();
                        axios.delete(`/admin/customers/${item.id}`).then(response => {
                            this.$swal.hideLoading();
                            this.$swal.fire(
                            'Eliminado!',
                            'Tu archivo fue eliminado.',
                            'success')
                            const index = this.searched.findIndex((x => x.id == item.id));
                            this.searched.splice(index,1);
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
        },closeDialog(){
            this.customer = null;
        }
    },
    created () {
        this.searched = this.data
    }
};
</script>
<style lang="sass" scoped>
    @media only screen and (max-width: 600px)
        .content-dialog
            display: block
</style>
