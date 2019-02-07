<template>
<div>
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-fixed-header>
        <md-table-toolbar>
            <div class="md-toolbar-section-start">
                <h1 class="md-title text-capitalize">{{ name }}s</h1>
            </div>

            <md-field md-clearable class="md-toolbar-section-end">
                <md-input placeholder="Buscar por nombre..." aria-label="Buscar por nombre..." v-model="search" @input="searchOnTable" />
            </md-field>
         </md-table-toolbar>

        <md-table-empty-state
            :md-label="`No se encontraron ${name}s`"
            :md-description="`Ningún ${name} encontrado para esta '${search}' consulta. Intente un término de búsqueda diferente o cree un nuevo ${name}.`">
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }">
            <md-table-cell v-if="false" md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
            <md-table-cell md-label="Nombre" md-sort-by="name">{{ item.name }}</md-table-cell>
            <md-table-cell v-if="item.price" md-label="Precio" md-sort-by="price" md-numeric>{{ item.price }}</md-table-cell>
            <md-table-cell v-if="item.url" md-label="Url" md-sort-by="url">{{ item.url }}</md-table-cell>
            <md-table-cell md-label="Acciones" >
                <md-button @click="edit(item)" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                <md-button class="md-icon-button" @click="deleteItem(item)"><md-icon>delete</md-icon></md-button>
            </md-table-cell>
        </md-table-row>
    </md-table>
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
    props: ['data','name','store','link'],
    data: () => ({
        search: null,
        searched: [],
    }),mounted(){
        //console.dir(this.data);
    },
    methods: {
        searchOnTable (){
            this.searched = searchByName(this.data, this.search)
        },
        edit(item){
            if(!this.store){
                window.location.href =  `/admin/${this.link}/${item.id}/edit`;
            }else{

            }
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
                        });
                    }
            })
        }
    },
    created () {
        this.searched = this.data
    }
};
</script>
