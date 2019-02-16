<template>
<div class="row">
    <div class="col-lg-4 list-reports">
        <md-list class="md-double-line w-100 mb-3">
            <md-subheader>Reportes</md-subheader>

            <md-list-item>
                <md-icon class="md-primary">insert_chart</md-icon>
                <div class="md-list-item-text">
                    <span>Productos más vendidos</span>
                    <span>Por fechas</span>
                </div>
                <md-button class="md-icon-button md-list-action" @click="reportSelected = 'top-product'">
                    <md-icon>remove_red_eye</md-icon>
                 </md-button>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
                <md-icon class="md-primary">table_chart</md-icon>
                <div class="md-list-item-text">
                    <span>Ventas</span>
                    <span>Por fechas</span>
                </div>
                <md-button class="md-icon-button md-list-action" @click="reportSelected = 'order-table-report'">
                    <md-icon>remove_red_eye</md-icon>
                 </md-button>
            </md-list-item>
            <md-divider></md-divider>
            <md-list-item>
                <md-icon class="md-primary">bar_chart</md-icon>
                <div class="md-list-item-text">
                    <span>Mejores clientes</span>
                    <span>Por fechas</span>
                </div>
                <md-button class="md-icon-button md-list-action" @click="reportSelected = 'top-customer'">
                    <md-icon>remove_red_eye</md-icon>
                 </md-button>
            </md-list-item>
        </md-list>
    </div>
    <top-product v-if="reportSelected == 'top-product'"></top-product>
    <order-table-report v-if="reportSelected == 'order-table-report'"></order-table-report>
    <top-customer v-if="reportSelected == 'top-customer'"></top-customer>
</div>

</template>
<script>
import topProduct from './reports/TopProductComponent';
import orderTable from './reports/OrderTableComponent';
import topCustomer from './reports/TopCustomerComponent';

export default {
    data: () => ({
        reportSelected: 'top-product'
    }),
    components: { 'top-product': topProduct,'order-table-report': orderTable,'top-customer': topCustomer },
    mounted() {

    },methods:{

    }
};
</script>
<style lang="sass">
    .list-reports
        @media only screen and (max-width: 992px)
            padding: 0
</style>

