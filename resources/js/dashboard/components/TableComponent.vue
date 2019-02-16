<template>
<md-card class="col-12">
    <md-button href="/admin/products/create" class="md-raised md-primary mt-3">Añadir nuevo</md-button>
    <md-card-content class="pl-0 pr-0 pt-0">
        <md-table v-model="searched.data" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-toolbar>
                <div class="md-toolbar-section-start">
                    <h1 class="md-title text-capitalize">{{ name }}s</h1>
                </div>

                <md-field md-clearable class="md-toolbar-section-end">
                    <md-input placeholder="Buscar..." aria-label="Buscar..." v-model="search" @input="searchOnTable" />
                </md-field>
            </md-table-toolbar>

            <md-table-empty-state
                :md-label="`No se encontraron ${name}s`"
                :md-description="`Ningún ${name} encontrado para esta '${search}' consulta. Intente un término de búsqueda diferente o cree un nuevo ${name}.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell v-if="false" md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Nombre" md-sort-by="name">{{ item.name }}</md-table-cell>
                <md-table-cell v-if="item.price" md-label="Precio" md-sort-by="price" md-numeric>S/ {{ item.price }}</md-table-cell>
                <md-table-cell v-if="item.url" md-label="Url" md-sort-by="url">{{ item.url }}</md-table-cell>
                <md-table-cell md-label="Acciones" >
                    <md-button @click="edit(item)" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                    <md-button class="md-icon-button" @click="deleteItem(item)"><md-icon>delete</md-icon></md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
        <pagination-material-component :data="this.searched" :search="search" @dataChange="searched = $event"></pagination-material-component>
    </md-card-content>
</md-card>
</template>
<script>

export default {
    props: ['data','name','link'],
    data: () => ({
        search: null,
        searched: [],
    }),mounted(){
        //console.dir(this.data);
    },
    methods: {
        searchOnTable (){
            axios.get(`/admin/products?json=true&search=${this.search}`).then(response => {
                this.searched = response.data;
            });
        },
        edit(item){
            window.location.href =  `/admin/${this.link}/${item.id}/edit`;
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
                        axios.delete(`/admin/${this.link}/${item.id}`).then(response => {
                            this.$swal.hideLoading();
                            this.$swal.fire(
                            'Eliminado!',
                            'Tu archivo fue eliminado.',
                            'success')
                            const index = this.searched.findIndex((x => x.id == item.id));
                            this.searched.splice(index,1);
                        }).catch(err => {
                            this.$swal.hideLoading();
                            //console.log(err.response);
                            if(err.response.status == 409){
                                this.$swal.fire(
                                    'Opps...!',
                                    err.response.data.message,
                                    'error')
                            }else{
                                this.$swal.fire(
                                    'Opps...',
                                    'Algo salio mal',
                                    'error'
                                );
                            }
                        });
                    }
            })
        }
    },
    created () {
        this.searched = this.data;
    }
};
</script>
