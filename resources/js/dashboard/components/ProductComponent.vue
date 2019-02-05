<template>
<div class="row">
    <md-card class="col-lg-8 info-product">
        <md-progress-bar class="md-primary" md-mode="indeterminate" v-if="sending"></md-progress-bar>
        <md-card-header>
            <div class="md-title">Datos del producto</div>
        </md-card-header>
        <md-card-content class="form-row">

            <md-field md-clearable v-bind:class="{ 'md-invalid': errors.first('name') }">
                <md-icon>rate_review</md-icon>
                <label>Nombre del producto </label>
                <md-input required :disabled="sending" v-model="form.name" data-vv-as="nombre" v-validate="'required|min:5'" data-vv-name="name" maxlength="300"></md-input>
                <span class="md-error">{{ errors.first('name') }}</span>
            </md-field>

            <div class="col-md-6 pl-0">
                <md-field md-clearable v-bind:class="{ 'md-invalid': errors.first('price') }">
                    <md-icon>monetization_on</md-icon>
                    <label>Precio</label>
                    <span class="md-prefix">S/</span>
                    <md-input type="number" :disabled="sending" v-model="form.price" data-vv-as="precio" v-validate="'required|min_value:3|max_value:99999999.99'" data-vv-name="price" required></md-input>
                    <span class="md-error">{{ errors.first('price') }}</span>
                </md-field>
            </div>

            <div class="col-md-6">
                <md-field md-clearable v-bind:class="{ 'md-invalid': errors.first('stock') }">
                    <md-icon>poll</md-icon>
                    <label>Stock</label>
                    <md-input type="number" :disabled="sending" v-model="form.stock" v-validate="'required|min_value:1|max_value:32767'" data-vv-name="stock" required></md-input>
                    <span class="md-error">{{ errors.first('stock') }}</span>
                </md-field>
            </div>
            <md-field md-clearable v-bind:class="{ 'md-invalid': errors.first('short_description') }">
                <md-icon>short_text</md-icon>
                <label>Descripción corta del producto</label>
                <md-textarea required :disabled="sending" maxlength="400" v-model="form.short_description" data-vv-as="descripción corta" data-vv-name="short_description" v-validate="'required|min:5'" :md-autogrow="true"></md-textarea>
                <span class="md-error">{{ errors.first('short_description') }}</span>
            </md-field>
            <md-field v-bind:class="{ 'md-invalid': errors.first('description') }">
                <label>Descripción del producto</label>
                <md-textarea :disabled="sending" v-model="form.description" required data-vv-as="descripción" data-vv-name="description" v-validate="'required|min:5'"></md-textarea>
                <md-icon>description</md-icon>
                <span class="md-error">{{ errors.first('description') }}</span>
            </md-field>

        </md-card-content>
        <md-card-actions>
            <md-button href="/admin/products" :disabled="sending">Atras</md-button>
            <md-button class="md-raised md-primary" v-if="!edit" :disabled="sending || errors.any()" @click="store()">Crear</md-button>
            <md-button class="md-raised md-primary" v-if="edit" :disabled="sending || errors.any()" @click="editProduct()">Actualizar</md-button>
        </md-card-actions>
    </md-card>
    <div class="col-lg-4 list-plus">
        <md-list :md-expand-single="true" class="pt-0 pb-0">
            <md-list-item md-expand :md-expanded="errors.first('category') ? true:false">
                <md-icon>style</md-icon>
                <span class="md-list-item-text">Categorías de productos</span>

                <md-list slot="md-expand" class="pl-3 pr-3">
                    <md-field v-bind:class="{ 'md-invalid': errors.first('category') }">
                        <md-icon>local_offer</md-icon>
                        <label for="category">Categoria</label>
                        <md-select :disabled="sending" name="category" id="category" v-model="form.category_id" data-vv-as="categoría" data-vv-name="category" v-validate="'required'">
                            <md-option v-for="category of categories" :key="category.id" :value="category.id" >{{category.name}}</md-option>
                        </md-select>
                        <span class="md-error">{{ errors.first('category') }}</span>
                    </md-field>
                    <md-button class="md-primary"  @click="activeDialog = true">Añadir nueva categoría</md-button>
                </md-list>
            </md-list-item>
            <md-list-item md-expand :md-expanded="true">
                <md-icon>photo_size_select_actual</md-icon>
                <span class="md-list-item-text">Imagen del producto</span>

                <md-list slot="md-expand" class="pl-3 pr-3">
                    <md-field v-bind:class="{ 'md-invalid': errors.first('cover') }">
                        <label>Imagen del producto</label>
                        <md-file :disabled="sending" @md-change="form.cover = $event[0]" v-model="form.file" accept="image/*" required/>
                        <span class="md-error">{{ errors.first('cover') }}</span>
                    </md-field>
                </md-list>
            </md-list-item>
        </md-list>
    </div>
    <md-dialog :md-active.sync="activeDialog" :md-close-on-esc="!sending" :md-click-outside-to-close="!sending" @md-closed="closeDialog()">
        <md-progress-bar class="md-primary" md-mode="indeterminate" v-if="sending"></md-progress-bar>
        <md-dialog-title>¡Ingresa una categoría!</md-dialog-title>
        <md-dialog-content>
            <md-field v-bind:class="{ 'md-invalid': errDialog }">
                <md-icon>local_offer</md-icon>
                <label>Nombre de la categría </label>
                <md-input v-model="newCategory" required maxlength="191" :disabled="sending"></md-input>
                <span class="md-error" v-if="errDialog">{{errDialog}}</span>
            </md-field>
        </md-dialog-content>

        <md-dialog-actions>
            <md-button :disabled="sending" class="md-primary" @click="activeDialog = false">Cerrar</md-button>
            <md-button :disabled="sending" class="md-raised md-primary" @click="createCategory()">Crear nueva categoría</md-button>
        </md-dialog-actions>
    </md-dialog>
    <md-snackbar md-position="center" :md-duration="2000" :md-active.sync="showSnackbar" md-persistent>
        <span>{{messageSnackbar}}</span>
        <md-button class="md-primary">Ok</md-button>
    </md-snackbar>
</div>
</template>
<script>
export default {
    props:['categoriesp','edit','product'],
    data: () => ({
        categories : [],
        activeDialog: false,
        showSnackbar: false,
        messageSnackbar: '',
        newCategory: null,
        errDialog: null,
        sending: false,
        form: {
            name: null,
            price: 0,
            stock: 0,
            short_description: null,
            description: null,
            category_id: null,
            cover: null
        }
    }),
    mounted(){
        this.categories = this.categoriesp;
        // set values
        this.form.name = this.product ? this.product.name:null;
        this.form.price = this.product ? this.product.price:1;
        this.form.stock = this.product ? this.product.stock:1;
        this.form.file = this.product ? this.product.cover:null;
        this.form.short_description = this.product ? this.product.short_description:null;
        this.form.description = this.product ? this.product.description:null;
        this.form.category_id = this.product ? this.product.category_id:null;
        if(this.product){
            let nameFile = this.product.cover.split("/");
            this.form.file = nameFile[nameFile.length - 1];
        }
    },
    methods: {
        createCategory(){
            this.sending = true;
            axios.post('/admin/categories',{name:this.newCategory}).then( response => {
                this.sending = false;
                this.newCategory = null;
                this.messageSnackbar = 'Exito. Se creo una nueva categoría!';
                this.showSnackbar = true;
                this.activeDialog = false;
                this.categories.push(response.data);
            }).catch(err => {
                if(err.response.status == 422){
                    this.errDialog = err.response.data.errors.name[0];
                }
                this.sending = false;
            });
        },closeDialog(){
            this.newCategory = null;
            this.errDialog = null;
        },store(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    this.sending = true;
                    const fd = this.createFormProduct();
                    axios.post('/admin/products',fd).then( response => {
                        this.sending = false;
                        this.messageSnackbar = 'Exito. Se creo un nuevo producto!';
                        this.showSnackbar = true;
                        this.setEmptyProduct();
                        this.$validator.reset();
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
        },editProduct(){
            this.$validator.validateAll().then((result) => {
                if (result){
                    this.sending = true;
                    const fdEdit = this.createFormProduct();
                    axios.post(`/admin/products/${this.product.id}`, fdEdit)
                    .then( response => {
                        this.sending = false;
                        this.messageSnackbar = 'Exito. Se actualizo su producto!';
                        this.showSnackbar = true;
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
        },setEmptyProduct(){
            this.form.name = null;
            this.form.price = 1;
            this.form.stock = 1;
            this.form.cover = null;
            this.form.short_description = null;
            this.form.description = null;
            this.form.category_id = null;
            this.form.file = null;
        },createFormProduct(){
            const fd = new FormData();
            if(this.form.cover){
                fd.append('cover',this.form.cover,this.form.cover.name);
            }
            if(this.edit){
                fd.append('_method','PATCH');
                fd.append('id',this.product.id);
            }
            fd.append('price',this.form.price);
            fd.append('name',this.form.name);
            fd.append('stock',this.form.stock);
            fd.append('short_description',this.form.short_description);
            fd.append('description',this.form.description);
            fd.append('category_id',this.form.category_id);
            return fd;
        }
    }
}
</script>
<style lang="sass" scoped>
    @media only screen and (max-width: 992px)
        .list-plus
            padding: 0 0 1rem 0
            order: 1
        .info-product
            order: 2
</style>
