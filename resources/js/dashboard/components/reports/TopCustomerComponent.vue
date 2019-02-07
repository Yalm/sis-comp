<template>
    <md-card class="col-lg-8">
        <md-progress-bar v-if="progress" class="md-primary p-report" md-mode="indeterminate"></md-progress-bar>
        <md-card-header>
            <div class="md-title">Top 10 de mejores clientes</div>
        </md-card-header>
        <md-card-content class="row">
            <div class="col-lg-6">
                <md-datepicker v-model="date_init" :md-inmediatamente="true" :disabled="progress">
                    <label>Fecha inicial</label>
                </md-datepicker>
            </div>
            <div class="col-lg-6">
                <md-datepicker v-model="date_end" :md-inmediatamente="true" :disabled="progress">
                    <label>Fecha final</label>
                </md-datepicker>
            </div>
            <canvas id="myChart" width="400" height="200"></canvas>
        </md-card-content>
        <md-card-actions>
            <md-button class="md-raised md-accent" :disabled="progress || data.length <1" @click="exportPdf()">
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
        myChart: null,
        progress: false,
        date_init: new Date(`${new Date().getFullYear()}/${new Date().getMonth()}/${new Date().getDate()}`),
        date_end: new Date(),
        data: []
    }),
    mounted() {
        const ctx = document.getElementById("myChart");
        this.myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Compras',
                    data: [],
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                        "rgba(0, 0, 0, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(255, 159, 64, 0.2)"
                    ],
                    borderColor: [
                        "rgba(255,99,132,1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                        "rgba(0, 0, 0, 0)",
                        "rgba(54, 162, 235)",
                        "rgba(75, 192, 192)",
                        "rgba(255, 159, 64)"
                    ],
                    borderWidth: 1
                }
            ]
            },
            options: {
                scales: { yAxes: [{ ticks: {beginAtZero: true} }] }
            }
        });
        this.filterDate();
    },methods:{
        filterDate(){
            this.progress = true;
            axios.get(`/admin/reports/topCustomer?date_init=${this.date_init.toJSON()}&date_end=${this.date_end.toJSON()}`).then(response => {
                this.removeInfoChart();
                this.data = response.data;
                for(let element of response.data){
                    this.myChart.data.labels.push(element.name);
                    this.myChart.data.datasets.forEach((dataset) => {
                        dataset.data.push(element.purchases);
                    });
                }
                this.myChart.update();
                this.progress = false;
                console.log(this.data);
            });
        },removeInfoChart(){
            this.myChart.data.labels = [];
            for(let dataset of this.myChart.data.datasets){
                dataset.data = [];
            }
            this.myChart.update();
        },exportPdf(){
            const pdfdoc = new jsPDF('p','pt');
            pdfdoc.text('Top 10 de mejores cliente',10,30);
            pdfdoc.autoTable({
                theme: 'grid',
                headStyles: { fillColor: [0, 0, 0]},
                columnStyles: {purchases: {halign: 'center'}},
                body: this.data,
                margin: {left: 10,top: 50},
                columns: [{header: 'Top', dataKey: 'top'},{header: 'Nombre', dataKey: 'name'}, {header: 'Apellidos', dataKey: 'surnames'},
                {header: 'Telefono', dataKey: 'phone'},
                {header: 'Correo', dataKey: 'email'},
                {header: 'Compras', dataKey: 'purchases'}]
            });
            pdfdoc.save('reporte.pdf');
        }
    }
};
</script>
<style lang="sass">
    .md-datepicker-dialog.md-theme-default
        max-height: 300px
        @media only screen and (max-width: 600px)
            max-height: 380px
    .p-report
        position: absolute
        top: 0
        left: 0
        height: 5px
        width: 100%
</style>
