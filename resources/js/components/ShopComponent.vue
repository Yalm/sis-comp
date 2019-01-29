<template>
<div class="container">
    <div class="row shop">
        <div class="col-md-3">
            <section class="category">
                <h4 class="category-title collapsed" data-toggle="collapse" href="#collapseCategory" role="button" aria-expanded="false" aria-controls="collapseCategory">Categorías</h4>
                <ul class="category-list collapse show" id="collapseCategory">
                    <li v-for="category of categories" :key="category.id">
                        <div class="custom-control custom-radio" @click="searchByCategory(category.id)">
                            <input type="radio" class="custom-control-input" :id="category.id" name="category">
                            <label class="custom-control-label search-link" :for="category.id">{{ `${category.name} (${category.products_count})` }}</label>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
        <div class="col-md-9">
            <ul class="nav nav-tabs d-flex justify-content-end" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="grid-tab" data-toggle="tab" href="#grid" role="tab" aria-controls="grid" aria-selected="true"><i class="material-icons">grid_on</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" aria-selected="false"><i class="material-icons">list</i></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" v-if="data">
                <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                    <div class="row">
                        <div class="col-xl-4 col-md-4 col-6" v-for="product of data.data" :key="product.id">
                            <product-component :product="product" @count="count = $event"></product-component>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="grid-tab">
                    <div v-for="product of data.data" :key="product.id">
                        <product-component :product="product" @count="count = $event" list="true"></product-component>
                    </div>
                </div>
                <div class="empty-products text-center" v-if="data.data.length < 1">
                    <i class="material-icons">hourglass_empty</i>
                    <p>NO SE ENCONTRARON PRODUCTOS</p>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['categories','categoryse','search'],
    data(){
        return {
            data: null
        }
    },
    mounted() {
        console.log(this.search);
        if(this.categoryse){
            this.searchByCategory(this.categoryse);
        }else if(this.search){
            axios.get(`/shop?search=${this.search}`).then(response => {
                this.data = response.data;
            });
        }else{
            axios.get('/shop').then(response => {
                this.data = response.data;
            });
        }
    },
    methods: {
        searchByCategory(category){
            axios.get(`/shop?category=${category}`).then(response => {
                this.data = response.data;
            });
        }
    }
};
</script>
