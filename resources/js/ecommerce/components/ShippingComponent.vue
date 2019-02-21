<template>
<div>
    <md-tabs md-alignment="fixed" @md-changed="shippingChange($event)">
        <md-tab id="tab-store" md-label="Recoger en tienda" md-icon="store">
            <p class="pt-3"> Para recoger tus artículos en Sis & Comp, debes llevar el número de pedido y un
                documento oficial de entidad con foto.</p>
                <span class="pt-2">Para mas información lee nuestros <b><a href="/">Terminos de Envio y Entrega</a></b></span>
        </md-tab>
        <md-tab id="tab-location" md-label="Envío a domicilio" name="movies" md-icon="location_on">
            <div class="alert alert-warning col-12 mt-3" role="alert">
                Por el momento solo se envía para los distritos de Huancayo.
            </div>
            <md-field>
                <label for="districtLo">Distrito</label>
                <md-select v-model="locationDistrict" id="districtLo" placeholder="Distrito">
                    <md-option v-for="district of locationDistricts" :key="district.id_ubigeo" :value="district.id_ubigeo">{{district.nombre_ubigeo}}</md-option>
                </md-select>
            </md-field>
            <md-field v-bind:class="{ 'md-invalid': errors.first('address') }">
                <md-icon>location_on</md-icon>
                <label>Dirección</label>
                <md-input v-model="address" data-vv-as="dirección" data-vv-name="address" v-validate="validatedAddress" maxlength="191"></md-input>
                    <span class="md-error">{{ errors.first('address') }}</span>
            </md-field>
        </md-tab>
        <!--<md-tab id="tab-truck" md-label="Envío por agencia" md-icon="train" class="row p-0 m-0 pt-3">
            <md-field class="col-lg-6">
                <label for="departament">Departamento</label>
                <md-select v-model="shipping.departament" id="departament" placeholder="Departamento" @md-selected="changeProvince($event)">
                    <md-option v-for="departament of shipping.departaments" :key="departament.id_ubigeo" :value="departament.id_ubigeo">{{departament.nombre_ubigeo}}</md-option>
                </md-select>
            </md-field>
            <md-field class="col-lg-6">
                <label for="province">Provincia</label>
                <md-select v-model="shipping.province" id="province" placeholder="Provincia" @md-selected="changeDistrict($event)">
                    <md-option v-for="province of shipping.provinces" :key="province.id_ubigeo" :value="province.id_ubigeo">{{province.nombre_ubigeo}}</md-option>
                </md-select>
            </md-field>
            <md-field>
                <label for="district">Distrito</label>
                <md-select v-model="shipping.district" id="district" placeholder="Distrito">
                    <md-option v-for="district of shipping.districts" :key="district.id_ubigeo" :value="district.id_ubigeo">{{district.nombre_ubigeo}}</md-option>
                </md-select>
            </md-field>
            <md-field v-bind:class="{ 'md-invalid': errors.first('address') }">
                <md-icon>location_on</md-icon>
                <label>Dirección</label>
                <md-input v-model="shipping.address" data-vv-as="dirección" data-vv-name="address" v-validate="'min:5|required'" maxlength="250"></md-input>
                    <span class="md-error">{{ errors.first('address') }}</span>
            </md-field>
        </md-tab>-->
    </md-tabs>
    <md-button class="md-raised md-primary" @click="setDone('second', 'third')">Continuar</md-button>
</div>

</template>
<script>

export default {
    data: () => ({
        methodShipping: 'store',
        validatedAddress: 'min:5',
        departament: '2534',
        departaments: Array,
        provinces: Array,
        province: '2557',
        locationDistrict: '3657',
        locationDistricts: Array,
        district: '2559',
        districs: Array,
        address: null
    }),
    mounted(){
        axios.get('../json/ubigeo/distritos.json').then(responseDistricts => {
            this.locationDistricts = responseDistricts.data['3656'];
        });

        axios.get('../json/ubigeo/departamentos.json').then(response => {
            this.departaments = response.data;
        });
    },
    methods: {
        changeProvince(departament_id) {
            axios.get('../json/ubigeo/provincias.json').then(responseProvinces => {
                this.shipping.provinces = responseProvinces.data[departament_id];
                this.shipping.province = this.shipping.provinces[0].id_ubigeo;
            });
        },changeDistrict(province_id){

            axios.get('../json/ubigeo/distritos.json').then(responseDistricts => {
                this.shipping.districts = responseDistricts.data[province_id];
                this.shipping.district = this.shipping.districts[0].id_ubigeo;
            });
        },
        shippingChange(shippingMethod){
            switch (shippingMethod){
                case 'tab-store':
                    this.methodShipping = 'store';
                    this.validatedAddress = 'min:5';
                    this.$emit('shippingChange',0);
                break;

                case 'tab-location':
                    this.methodShipping = 'location';
                    this.validatedAddress = 'min:5|required';
                    this.$emit('shippingChange',10);
                break;

                case 'tab-truck':
                    this.methodShipping = 'truck';
                    this.validatedAddress = 'min:5';
                    this.$emit('shippingChange',15);
                break;
            }

        },setDone(){
            this.$validator.validate().then(result => {
                if(result){
                    this.$emit('data',this.createData());
                    this.$emit('next',{id:'second',index:'third'});
                }else{
                    this.$emit('err','Error');
                }
            });
        },createData(){
            switch (this.methodShipping){
                case 'store':
                    return null;
                break;
                case 'location':
                    const shipping =  {
                        district: {
                            id: this.locationDistrict,
                            name: this.locationDistricts.find(x => x.id_ubigeo === this.locationDistrict).nombre_ubigeo
                        },
                        address: this.address
                    }
                    return shipping;
                break;
            }
        }
    }
}
</script>
