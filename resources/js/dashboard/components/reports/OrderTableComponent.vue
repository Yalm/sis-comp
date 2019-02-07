<template>
<md-card class="col-lg-8 pl-0 pr-0">
    <md-progress-bar v-if="progress" class="md-primary p-report" md-mode="indeterminate"></md-progress-bar>
    <md-card-content v-if="orders">
        <md-table v-model="orders.data" md-sort="customer" md-sort-order="asc">
            <md-table-toolbar>
                <div class="md-toolbar-section-start">
                    <h1 class="md-title">Ventas</h1>
                </div>
                <md-datepicker v-model="date_init" :md-inmediatamente="true" :disabled="progress" class="md-toolbar-section-end mr-3">
                    <label>Fecha inicial</label>
                </md-datepicker>
                <md-datepicker v-model="date_end" :md-inmediatamente="true" :disabled="progress" class="md-toolbar-section-end">
                    <label>Fecha final</label>
                </md-datepicker>
            </md-table-toolbar>
            <md-table-empty-state
                :md-label="`No se encontraron ventas`"
                :md-description="`Ningúna venta encontrado para esta consulta. Intente un término de búsqueda diferente o cree un nueva venta.`">
            </md-table-empty-state>

            <md-table-row slot="md-table-row" slot-scope="{ item }">
                <md-table-cell md-label="Cliente" md-sort-by="customer">{{ item.customer }}</md-table-cell>
                <md-table-cell md-label="Estado" md-sort-by="state" class="let">{{ item.state }}</md-table-cell>
                <md-table-cell md-label="Monto" md-sort-by="amount">S/ {{ item.amount }}</md-table-cell>
                <md-table-cell md-label="Metodo P." md-sort-by="method">{{ item.method }}</md-table-cell>
                <md-table-cell md-label="Fecha" md-sort-by="date" class="let">{{ item.date }}</md-table-cell>
            </md-table-row>
        </md-table>
        <div class="pagination-table d-flex justify-content-end align-items-center pt-2" v-if="orders && orders.total > orders.per_page">
            <span class="text-pagination">{{`${orders.from}-${orders.per_page} de ${orders.total}`}}</span>
            <md-button class="md-icon-button ml-3" :disabled="orders.from == 1 || progress" @click="nextPage(orders.prev_page_url)">
                <md-icon>keyboard_arrow_left</md-icon>
            </md-button>
           <md-button class="md-icon-button" @click="nextPage(orders.next_page_url)" :disabled="orders.current_page == orders.last_page || progress">
                <md-icon>keyboard_arrow_right</md-icon>
            </md-button>
        </div>
    </md-card-content>
    <md-card-actions>
        <md-button class="md-raised md-accent" :disabled="progress || orders.data.length <1" @click="exportPdf()">
            <md-icon>picture_as_pdf</md-icon>
            Exportar a PDF
        </md-button>
        <md-button class="md-raised md-primary" :disabled="progress" @click="filterDate()">
            <md-icon>filter_list</md-icon>
            Filtrar
        </md-button>
    </md-card-actions>
</md-card>
</template>
<script>
import jsPDF from 'jspdf';
import 'jspdf-autotable';

export default {
    data: () => ({
        orders: {
            data: []
        },
        progress: false,
        date_init: new Date(`${new Date().getFullYear()}/${new Date().getMonth()}/${new Date().getDate()}`),
        date_end: new Date(),
    }),mounted(){
        this.filterDate();
    },methods:{
        filterDate(){
            this.progress = true;
            axios.get(`/admin/reports/purchases?date_init=${this.date_init.toJSON()}&date_end=${this.date_end.toJSON()}&page=1`).then(response => {
                this.orders = response.data;
                this.progress = false;
                console.log(this.orders);
            });
        },nextPage(page){
            this.progress = true;
            axios.get(`${page}&date_init=${this.date_init.toJSON()}&date_end=${this.date_end.toJSON()}`).then(response => {
                this.orders = response.data;
                this.progress = false;
            });
        },exportPdf(){
            const pdfdoc = new jsPDF('p','pt');
            pdfdoc.text('Ventas',10,30);
            pdfdoc.autoTable({
                theme: 'grid',
                headStyles: { fillColor: [0, 0, 0]},
                body: this.orders.data,
                margin: {left: 10,top: 50},
                columns: [{header: 'Cliente', dataKey: 'customer'}, {header: 'Estado', dataKey: 'state'},
                {header: 'Monto', dataKey: 'amount'}, {header: 'Metodo P.', dataKey: 'method'}, {header: 'Fecha', dataKey: 'date'}]
            });
            pdfdoc.save('reporte.pdf');
        }
    }
};
</script>
<style lang="sass" scoped>
    .pagination-table
        .text-pagination
            font-size: 12px
</style>
