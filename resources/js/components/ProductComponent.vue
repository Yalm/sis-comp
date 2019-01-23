<template>
<div class="container-fluid">
    <div class="row product-view">
        <div class="product-thumbnail col-12" v-bind:class="{ sold_out_product: product.stock < 1 }">
            <span class="sold_out">Agotado</span>
            <div class="sold_out-back"></div>
            <a v-bind:href="product.url"><img class="img-fluid" :src="product.cover" v-bind:alt="product.name"></a>
            <div class="product-actions">
                <!--<<button v-bind:disabled="progress" v-on:click="showProduct()" type="button" v-bind:class="{ in_progress: progress }" title="Vista rápida"><i class="material-icons">{{ progress ? 'replay':'remove_red_eye' }}</i></button>-->
                <button v-bind:disabled="progress" type="button" class="add-cart" v-bind:class="{ in_progress: progress }" title="Agregar al carrito" v-on:click="addCartProduct()"><i class="material-icons">{{ progress ? 'replay':'shopping_cart' }} </i></button>
            </div>
        </div>
        <div class="product-content col-12">
            <!--<h6 class="product-brand">{{ product.category.id }}</h6>-->
            <h3 class="product-title text-left">
                <a v-bind:href="product.address"> {{ product.name }}</a>
            </h3>
            <p v-if="list" class="product-description">{{ product.description }}</p>
            <div class="product-price-and-shipping">
                <span class="price">S/{{ product.price }}</span>
            </div>
            <button v-if="list" type="submit" class="btn-siscom">Agregar al carrito</button>
            <button type="button" aria-label="add product" class="add-product"><i class="fas fa-shopping-cart"></i></button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['product','list'],
    data(){
        return {
            progress: false
        }
    },
    methods: {
        addCartProduct(){
            this.progress = true;
            axios.post(`/cart`, {
                id: this.product.id,
                name: this.product.name,
                price: this.product.price,
                quantity: 1,
                cover: this.product.cover,
                stock: this.product.stock
            }).then(response => {
                this.$emit('count',response.data.count_cart);
                this.$swal(this.product.name, 'Se agrego al carrito !', 'success');
                this.progress = false;
            })
            .catch(e => { this.progress = false; console.log(e); });
        },
        showProduct(){}
    }
};
</script>
