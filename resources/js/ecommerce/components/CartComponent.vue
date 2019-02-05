<template>
<div class="container" v-if="mutableList">
    <div class="row cart" v-if="mutableList.length >= 1">
        <div class="col-md-7 col-12" >
            <div class="card cart-items" v-bind:class="{ loading:progress }">
                <div class="card-header text-uppercase card-header-black ">
                    Carrito de compras
                </div>
                <div class="card-body" v-for="item in mutableList" :key="item.id">
                    <div class="row">
                        <a class="col-3" v-bind:href="`/p/${item.attributes.url}`">
                            <img class="img-fluid" :src="item.attributes.cover" v-bind:alt="item.name" >
                        </a>

                        <div class="col-9 d-flex align-items-start">
                            <a v-bind:href="`/p/${item.attributes.url}`">
                                <h5 class="mt-0 item-cart-text">{{ item.name }}</h5>
                            </a>
                            <div class="content-cart d-flex justify-content-end">
                                <div class="actions-cart d-flex">
                                    <input name="quantity" min="1" v-bind:max="item.attributes.stock" type="number" class="qty" v-model="item.quantity">
                                    <button class="button-actions" v-on:click="updatedItem(item.id)" >
                                        <i class="material-icons">update</i>
                                    </button>
                                    <button v-on:click="deleteItem(item.id)" class="button-actions">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                                <span class="price-item-cart">S/{{item.quantity * item.price}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5" >
            <div class="card checkout-review-order">
                <table class="checkout-review-table">
                    <tfoot>
                        <tr class="title">
                            <th>TOTAL DEL CARRITO</th>
                        </tr>
                        <tr class="cart-subtotal">
                            <th>Subtotal</th>
                            <td>
                                <b class="amount">
                                    S/{{ myTotal || total }}
                                </b>
                            </td>
                        </tr>
                        <tr class="order-total order_total_1">
                            <th>Total</th>
                            <td>
                                <span class="amount">
                                    S/ {{ myTotal || total }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a class="btn-siscom" href="/checkout" >Finalizar Compra</a>
            </div>
        </div>
    </div>
    <div class="cart_empty text-center" v-if="mutableList.length < 1" >
        <i class="material-icons">shopping_cart</i>
        <p>Tu carrito está vacío.</p>
        <a class="cart_empty-link" href="/shop">Volver a la tienda</a>
    </div>
</div>
</template>

<script>
export default {
    props: ['cart','total'],
    data() {
        return {
            progress: false,
            myTotal: null,
            mutableList: this.arrayXd(this.cart)
        }
    },
    mounted() {},
    methods: {
        deleteItem(key) {
            this.progress = true;
            const search = this.mutableList.findIndex((x => x.id == key));
            axios.delete(`cart/${key}`).then(response => {
                this.mutableList.splice(search,1);
                this.myTotal = response.data.total;
                this.$emit('count',response.data.count_cart);
                this.progress = false;
            });
        },
        updatedItem(key) {
            this.progress = true;
            const index = this.mutableList.findIndex((x => x.id == key));
            const qty = this.mutableList[index].quantity;
            axios.put(`cart/${key}`,{qty: qty}).then(response => {
                this.myTotal = response.data.total;
                this.progress = false;
                this.$emit('count',response.data.count_cart);
            });
        },
        arrayXd(){
            const result = Object.keys(this.cart).map((key) => {
                return [Number(key), this.cart[key]];
            });
            const sd = new Array();
            result.forEach((item,index) => {
                item.forEach((item2,index2) => {
                    if(item2.id) {
                    sd.push(item2);
                    }
                });
            });
            return sd;
        }
    }
};
</script>
