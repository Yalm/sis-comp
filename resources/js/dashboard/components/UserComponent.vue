<template>
<div>
    <md-button @click="create()" class="md-raised md-primary mt-3">Añadir nuevo</md-button>
    <md-card-content>
        <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header>
            <md-table-toolbar>
                <div class="md-toolbar-section-start">
                    <h1 class="md-title text-capitalize">Usuarios</h1>
                </div>

                <md-field md-clearable class="md-toolbar-section-end">
                    <md-input placeholder="Buscar por nombre..." aria-label="Buscar por nombre..." v-model="search" @input="searchOnTable" />
                </md-field>
            </md-table-toolbar>

            <md-table-empty-state
                md-label="No se encontraron usuarios"
                :md-description="`Ningúna usuario encontrado para esta '${search}' consulta. Intente un término de búsqueda diferente o cree una nueva usuario.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="Nombre" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell md-label="Apellidos" md-sort-by="surnames">{{ item.surnames }}</md-table-cell>
                <md-table-cell md-label="Correo" md-sort-by="email">{{ item.email }}</md-table-cell>
                <md-table-cell md-label="Acciones" >
                    <md-button @click="edit(item)" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                    <md-button class="md-icon-button" @click="deleteItem(item)"><md-icon>delete</md-icon></md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
    </md-card-content>
    <md-dialog :md-active.sync="activeDialog" :md-close-on-esc="!sending" :md-click-outside-to-close="!sending" @md-closed="closeDialog()">
        <md-progress-bar class="md-primary" md-mode="indeterminate" v-if="sending"></md-progress-bar>
        <md-dialog-title>{{ editBtn ? '¡Actualizar Usuario!':'¡Ingresa un Usuario!' }}</md-dialog-title>
        <md-dialog-content class="row">
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('name') }">
                    <md-icon>face</md-icon>
                    <label>Nombre</label>
                    <md-input v-model="user.name" required maxlength="191" :disabled="sending" data-vv-as="nombre" data-vv-name="name" v-validate="'required|min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('name') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('surnames') }">
                    <md-icon>face</md-icon>
                    <label>Apellidos</label>
                    <md-input v-model="user.surnames" required maxlength="191" :disabled="sending" data-vv-as="apellidos" data-vv-name="surnames" v-validate="'min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('surnames') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('email') }">
                    <md-icon>email</md-icon>
                    <label>Correo</label>
                    <md-input v-model="user.email" required maxlength="191" :disabled="sending" data-vv-as="correo" data-vv-name="email" v-validate="'required|email|min:5|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('email') }}</span>
                </md-field>
            </div>
            <div class="col-md-6">
                <md-field v-bind:class="{ 'md-invalid': errors.first('password') }">
                    <md-icon>lock</md-icon>
                    <label>Contraseña</label>
                    <md-input v-model="user.password" maxlength="191" type="password" :disabled="sending" data-vv-as="contraseña" data-vv-name="password" v-validate="'min:6|max:191'"></md-input>
                    <span class="md-error">{{ errors.first('password') }}</span>
                </md-field>
            </div>
            <div class="col-12">
                <md-switch  v-if="editBtn" v-model="user.actived" class="md-primary">Activo</md-switch>
            </div>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button :disabled="sending" class="md-primary" @click="activeDialog = false">Cerrar</md-button>
            <md-button :disabled="sending || errors.any()" class="md-raised md-primary" @click="store()" v-if="!editBtn">Crear nuevo usuario</md-button>
            <md-button :disabled="sending || errors.any()" class="md-raised md-primary" @click="updated()" v-if="editBtn">Actualizar usuario</md-button>
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
        user: {
            name:null,
            id:null,
            email:null,
            surnames: null,
            password: null,
            actived: false
        },
        editBtn: false,
        sending: false
    }),mounted(){
        //console.dir(this.data);
    },
    methods: {
        searchOnTable (){
            this.searched = searchByName(this.data, this.search)
        },updated(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    axios.put(`/admin/users/${this.user.id}`,this.user)
                    .then( response => {
                        this.sending = false;
                        this.closeDialog();
                        this.messageSnackbar = 'Exito. Se actualizo su usuario!';
                        this.showSnackbar = true;
                        this.activeDialog = false;
                        const index = this.searched.findIndex((x => x.id == response.data.id));
                        this.searched[index] = response.data;
                    }).catch(err => {
                        if(err.response.status == 422){
                            for(const error in err.response.data.errors){
                                this.$validator.errors.add({
                                    field: error,
                                    msg: err.response.data.errors[error][0]
                                });
                            }
                        }
                        this.sending = false;
                    });;
                }
            });
        },create(){
            this.editBtn = false;
            this.activeDialog = true;
        },
        store(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    axios.post('/admin/users',this.user).then( response => {
                        this.sending = false;
                        this.closeDialog();
                        this.messageSnackbar = 'Exito. Se creo una nuevo usuario!';
                        this.showSnackbar = true;
                        this.activeDialog = false;
                        this.searched.push(response.data);
                    }).catch(err => {
                        if(err.response.status == 422){
                            for(const error in err.response.data.errors){
                                this.$validator.errors.add({
                                    field: error,
                                    msg: err.response.data.errors[error][0]
                                });
                            }
                        }
                        this.sending = false;
                    });
                }
            });
        },
        edit(item){
            this.activeDialog = true;
            this.user = {
                id: item.id,
                name: item.name,
                surnames: item.surnames,
                email: item.email,
                actived: item.actived
            };
            this.editBtn = true;
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
                        axios.delete(`/admin/users/${item.id}`).then(response => {
                            this.$swal.hideLoading();
                            this.$swal.fire(
                            'Eliminado!',
                            'Tu archivo fue eliminado.',
                            'success')
                            const index = this.searched.findIndex((x => x.id == item.id));
                            this.searched.splice(index,1);
                        });
                    }
            })
        },closeDialog(){
            this.user = {id:null,name:null,surnames:null,email:null};
        }
    },
    created () {
        this.searched = this.data
    }
};
</script>
