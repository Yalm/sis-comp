<template>
    <a class="p-2 cart-button" href="/cart">
        <i class="material-icons">shopping_cart</i>
        <span class="cart-products-count">{{ count }}</span>
    </a>
</template>

<script>
export default {
    props: ['count'],
    data(){
        return {}
    },
    mounted() {
        //console.dir(this.count);
    }
};
</script>
