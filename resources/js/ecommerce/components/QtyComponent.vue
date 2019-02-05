<template>

<div class="container-fluid qty">
    <p class="available">{{ showStock - qty }} disponibles</p>
    <div class="row">
        <div class="col-5 d-flex align-items-center">
            <input type="number" readonly="true" v-model="qty" id="qty" class="num-qty" :max="product.stock">
            <span class="input-group-btn-vertical">
                <button @click="quantityUp()" class="btn-qty-up" type="button"><i class="material-icons">keyboard_arrow_up</i></button>
                <button @click="quantityDown()" class="btn-qty-down" type="button"><i class="material-icons">keyboard_arrow_down</i></button>
            </span>
        </div>
        <div class="col-7">
            <button :disabled="progress || qty < 1" class="btn-siscom height-btn" @click="addCartProduct()">{{ product.stock > 0 ? 'Agregar al carrito':'Agotado'}}</button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['product'],
    data(){
        return {
            progress: false,
            qty: 0,
            showStock: this.product.stock
        }
    },
    mounted() {

    },
    methods:{
        quantityUp(){
            if (this.qty >= this.product.stock) {
                this.qty  = this.qty;
            }else{
                this.qty++;
            }
        },
        quantityDown(){
            if (this.qty <= 0) {
                this.qty  = this.qty;
            } else {
                this.qty--;
            }
        },
        addCartProduct(){
            this.progress = true;
            axios.post(`/cart`, {
                id: this.product.id,
                name: this.product.name,
                price: this.product.price,
                qty: this.qty,
                cover: this.product.cover,
                stock: this.product.stock,
                url: this.product.url
            }).then(response => {
                this.$emit('add',response.data.count_cart);
                this.$swal(this.product.name, 'Se agrego al carrito !', 'success');
                this.progress = false;
            })
            .catch(e => {
                this.progress = false;
                this.$swal('Error', 'Stock superado', 'error');
            });
        },
    }
};
</script>
