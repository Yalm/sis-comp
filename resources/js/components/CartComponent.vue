<template>
<div class="container" v-if="mutableList">
    <div class="row cart" v-if="mutableList.length >= 1">
        <div class="col-md-8 col-12" >
            <div class="card cart-items">
                <div class="card-header text-uppercase card-header-black ">
                    Carrito de compras
                </div>
                <div class="card-body" v-for="item in mutableList" :key="item.id">
                    <div class="row">
                        <div class="col-3">
                            <img class="img-fluid" :src="item.attributes.cover" v-bind:alt="item.name" >
                        </div>

                        <div class="col-9 d-flex align-items-start">
                            <h5 class="mt-0 item-cart-text">{{ item.name }}</h5>
                            <div class="content-cart d-flex">
                                <div class="actions-cart d-flex">
                                    <input name="quantity" min="1" max="10" type="number" class="qty" v-bind:value="item.quantity">
                                    <button>
                                        <i class="material-icons">update</i>
                                    </button>
                                    <button v-on:click="deleteItem(item.id)">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                                <span class="price-item-cart">S/{{item.price}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4" >
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
                                    S/.300.00
                                </b>
                            </td>
                        </tr>
                        <tr class="order-total order_total_1">
                            <th>Total</th>
                            <td>
                                <span class="amount">
                                    S/.300.00
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a class="btn-siscom" routerLink="/checkout">Finalizar Compra</a>
            </div>
        </div>
    </div>
    <div class="cart_empty text-center" v-if="mutableList.length < 1" >
        <i class="material-icons">shopping_cart</i>
        <p>Tu carrito está vacío.</p>
        <a class="cart_empty-link" routerLink="/shop">Volver a la tienda</a>
    </div>
</div>
</template>

<script>
export default {
    props: ['cart'],
    data() {
        return {
            mutableList: this.arrayXd(this.cart)
        }
    },
    mounted() {

    },
    methods: {
        deleteItem(key) {
            //this.cart.splice(this.cart.indexOf(key), 1);
            console.log(this.mutableList);
            this.mutableList.splice(this.mutableList.indexOf(key),1);
            /*axios.delete(`cart/${key}`).then(response => {
                delete this.cart['key'];
                console.log(response);
            });*/
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
