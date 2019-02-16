<template>
<div class="container-fluid">
    <div class="row product-view">
        <div class="product-thumbnail" v-bind:class="[list ? 'col-md-4':'col-12',{ sold_out_product: product.stock < 1}]">
            <span class="sold_out">Agotado</span>
            <div class="sold_out-back"></div>
            <a v-bind:href="`/p/${product.url}`"><img class="img-fluid" :src="product.cover" v-bind:alt="product.name"></a>
            <div class="product-actions">
                <!--<<button v-bind:disabled="progress" v-on:click="showProduct()" type="button" v-bind:class="{ in_progress: progress }" title="Vista rápida"><i class="material-icons">{{ progress ? 'replay':'remove_red_eye' }}</i></button>-->
                <button v-bind:disabled="progress" type="button" class="add-cart" v-bind:class="{ in_progress: progress }" title="Agregar al carrito" v-on:click="addCartProduct()"><i class="material-icons">{{ progress ? 'replay':'shopping_cart' }} </i></button>
            </div>
        </div>
        <div class="product-content" v-bind:class="[list ? 'col-md-8 pl-2':'col-12']">
            <!--<h6 class="product-brand">{{ product.category.id }}</h6>-->
            <h3 class="product-title text-left">
                <a v-bind:href="`/p/${product.url}`"> {{ product.name }}</a>
            </h3>
            <p v-if="list" class="product-description">{{ product.short_description }}</p>
            <div class="product-price-and-shipping">
                <span class="price">S/ {{ product.price }}</span>
            </div>
            <button v-if="list" type="submit" v-on:click="addCartProduct()" aria-label="add product" class="btn-siscom">Agregar al carrito</button>
            <button type="button" v-on:click="addCartProduct()" aria-label="add product" class="add-product"><i class="material-icons">shopping_cart</i></button>
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
                qty: 1,
                cover: this.product.cover,
                stock: this.product.stock,
                url: this.product.url
            }).then(response => {
                this.$emit('count',response.data.count_cart);
                this.$swal(this.product.name, 'Se agrego al carrito !', 'success');
                this.progress = false;
            })
            .catch(e => {
                this.progress = false;
                this.$swal('Error', 'Stock superado', 'error');
            });
        },
        showProduct(){}
    }
};
</script>
