<template>
<md-card class="col-12 pl-0 pr-0" v-if="searched">
    <md-card-content class="pl-0 pr-0 pt-0">
        <md-table v-model="searched.data" md-sort="name" md-sort-order="asc" md-fixed-header>
            <md-table-toolbar>
                <div class="md-toolbar-section-start">
                    <h1 class="md-title text-capitalize">{{ name }}s</h1>
                </div>

                <md-field class="md-toolbar-section-end">
                    <md-input placeholder="Buscar..." aria-label="Buscar..." v-model="search" @input="searchOnTable" />
                </md-field>
            </md-table-toolbar>

            <md-table-empty-state
                :md-label="`No se encontraron ${name}s`"
                :md-description="`Ningún ${name} encontrado para esta '${search}' consulta. Intente un término de búsqueda diferente o cree un nuevo ${name}.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="Numero" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                <md-table-cell md-label="Fecha" md-sort-by="date" class="text-capitalize">{{ item.date }}</md-table-cell>
                <md-table-cell md-label="Estado" md-sort-by="state" :class="`text-capitalize ${getColorState(item.state_id)}`">{{ item.state.name }}</md-table-cell>
                <md-table-cell md-label="Monto" md-sort-by="amount" >S/ {{ item.payment.amount }}</md-table-cell>
                <md-table-cell md-label="Cliente" md-sort-by="customer">{{ item.customer.name }}</md-table-cell>
                <md-table-cell md-label="Acciones" >
                    <md-button @click="edit(item)" class="md-icon-button"><md-icon>edit</md-icon></md-button>
                </md-table-cell>
            </md-table-row>
        </md-table>
        <pagination-material-component :data="this.searched" :search="search" @dataChange="searched = $event"></pagination-material-component>
    </md-card-content>
</md-card>
</template>
<script>
export default {
    props: ['name','store','link'],
    data: () => ({
        search: null,
        searched: null,
    }),
    methods: {
        searchOnTable (){
            axios.get(`/admin/orders?json=true&search=${this.search}`).then(response => {
                this.searched = response.data;
            });
        },
        edit(item){
            window.location.href =  `/admin/${this.link}/${item.id}/edit`;
        },getColorState(id){
            switch (id) {
                case 1:
                    return 'text-danger';
                    break;
                case 2:
                    return 'text-success';
                    break;
                case 3:
                    return 'text-warning';
                    break;
                case 4:
                    return 'text-primary';
                    break;
                default:
                    return "text-danger";
            }
        }
    },
    created () {
        axios.get(`/admin/orders?page=1&json=true&search=${this.search}`).then(response => {
            this.searched = response.data;
        });
    }
};
</script>
