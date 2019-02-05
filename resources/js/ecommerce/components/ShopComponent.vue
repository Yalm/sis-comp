<template>
<div class="container">
    <div class="row shop">
        <div class="col-md-3">
            <section class="list-filters" v-if="filters.length > 0">
                <h6 class="pb-1">Filtros</h6>
                <div class="list-filters-content pt-1 mb-4">
                    <md-chip class="md-primary mt-1" v-for="filter of filters" :key="filter.filter" md-deletable @md-delete="deleteFilter(filter)">{{filter.val}}</md-chip>
                </div>
            </section>
            <section class="filter-price pb-3">
                <h6 class="pb-2">FILTRO POR PRECIO</h6>
                <div id="slider"></div>
                <div class="content-filter-price d-flex justify-content-between pt-3 align-items-center">
                     <p class="mb-0">Precio: {{min}} - {{max}}</p>
                    <md-button class="md-raised md-primary" @click="filterPrice()">Filtrar</md-button>
                </div>
            </section>
            <section class="category">
                <h4 class="category-title collapsed" data-toggle="collapse" href="#collapseCategory" role="button" aria-expanded="false" aria-controls="collapseCategory">Categorías</h4>
                <ul class="category-list collapse show" id="collapseCategory">
                    <li v-for="category of categories" :key="category.id">
                        <md-radio v-model="radio" class="mt-1 mb-1 md-primary" @change="searchByCategory($event)" :value="category.id">{{ `${category.name} (${category.products_count})` }}</md-radio>

                        <!--<div class="custom-control custom-radio" @click="searchByCategory(category.id)">
                            <input type="radio" class="custom-control-input" :id="category.id" name="category">
                            <label class="custom-control-label search-link" :for="category.id">{{ `${category.name} (${category.products_count})` }}</label>
                        </div>-->
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
                            <product-component :product="product" @count="changeCount($event)"></product-component>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="grid-tab">
                    <div v-for="product of data.data" :key="product.id">
                        <product-component :product="product" @count="changeCount($event)" list="true"></product-component>
                    </div>
                </div>
                <div class="empty-products text-center" v-if="data.data.length < 1">
                    <i class="material-icons">hourglass_empty</i>
                    <p>NO SE ENCONTRARON PRODUCTOS</p>
                </div>
            </div>
            <nav aria-label="Page navigation example" class="d-flex justify-content-center pt-4" v-if="data && data.total > data.per_page">
                <ul class="pagination">
                    <li class="page-item" v-if="data.prev_page_url">
                        <a class="page-link" @click="nextPage(data.prev_page_url)" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="page of pages" :key="page" v-bind:class="[data.current_page == page ? 'active':'']"><span class="page-link" @click="changePage(page)">{{page}}</span></li>
                    <li class="page-item" v-if="data.next_page_url">
                        <a class="page-link" @click="nextPage(data.next_page_url)" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['categories','maxp'],
    data: () => ({
        data: null,
        radio: false,
        pages: [],
        min: 0,
        max: 0,
        page: 1,
        filters: []
    }),mounted() {

        this.$router.push({ query: { ...this.$router.history.current.query,page: 1 }});

        this.radio = this.$router.history.current.query.category ? Number(this.$router.history.current.query.category):false;
         this.page = this.$router.history.current.query.page ? this.$router.history.current.query.page:false;

        if(this.$router.history.current.query.category){
            this.searchByCategory(this.$router.history.current.query.category);
        }else if(this.$router.history.current.query.search){
            axios.get(`/shopJson?search=${this.$router.history.current.query.search}`).then(response => {
                this.data = response.data;
                this.setPages(response.data.last_page);
            });
        }else{
            axios.get(`/shopJson?page=${this.page}`).then(response => {
                this.data = response.data;
                this.setPages(response.data.last_page);
            });
        }
        this.setSlider(this.maxp);
        this.setFilters();
    },
    methods: {
        searchByCategory(category){
            this.$router.replace({ query: { ...this.$router.history.current.query,category: this.radio }});
            axios.get(`/shopJson?category=${category}&min_price=${this.$router.history.current.query.min_price}&max_price=${this.$router.history.current.query.max_price}`).then(response => {
                this.data = response.data;
                this.setPages(response.data.last_page);
                this.setFilters();
            });
        },changeCount(count){
            this.$emit('count',count);
        },setPages(max){
            if(this.pages.length < 1){
                for (let i = 0; i < max; i++) {
                    let page = i +1;
                    this.pages.push(page);
                }
            }else{
                this.pages = [];
                for (let i = 0; i < max; i++) {
                    let page = i +1;
                    this.pages.push(page);
                }
            }
        },nextPage(url){
            axios.get(`${url}&category=${this.radio}`).then(response => {
                this.data = response.data;
                this.setPages(response.data.last_page);
                this.$router.replace({ query: { ...this.$router.history.current.query,page: this.data.current_page }});
            });
        },changePage(page){
            this.$router.replace({ query: { ...this.$router.history.current.query,page: page }});
            axios.get(`/shopJson?page=${page}&category=${this.radio}`).then(response => {
                this.data = response.data;
                this.setPages(response.data.last_page);
            });
        },setSlider(maxPrice){
            const slider = document.getElementById('slider');
            const start = this.$router.history.current.query.min_price || (maxPrice/4);
            const end = this.$router.history.current.query.max_price || (maxPrice/2);
            noUiSlider.create(slider, {
                start: [start, end],
                connect: true,
                range: {
                    'min': 0,
                    'max': maxPrice
                }
            });
            slider.noUiSlider.on('update', (values, handle) => {
                this.min = values[0];
                this.max = values[1];
            });
        },filterPrice(){
            axios.get(`/shopJson?page=${this.page}&category=${this.radio}&min_price=${this.min}&max_price=${this.max}`).then(response => {
                this.data = response.data;
                this.$router.replace({ query: { ...this.$router.history.current.query,min_price: this.min,max_price:this.max }});
                this.setPages(response.data.last_page);
                this.setFilters();
            });
        },deleteFilter(filter){
            switch (filter.filter) {
                case 'category':
                    this.radio = false;
                    this.searchByCategory(this.radio);
                    this.$router.replace({ query: { ...this.$router.history.current.query,category: undefined }});
                break;
                case 'price':
                    this.$router.replace({ query: { ...this.$router.history.current.query,min_price: undefined,max_price:undefined }});
                    this.searchByCategory(this.radio);
                break;
                case 'search':
                    this.$router.replace({ query: { ...this.$router.history.current.query,search: undefined }});
                    this.searchByCategory(this.radio);
                break;
            }
            let index = this.filters.findIndex((x => x.filter == filter.filter));
            this.filters.splice(index,1);
        },setFilters(){
            this.filters = [];
            for(let query in this.$router.history.current.query){
                switch (query) {
                    case 'category':
                        let index = this.categories.findIndex((x => x.id == this.$router.history.current.query[query]));
                        if(index >= 0){
                            let data = { filter: query,val: this.categories[index].name };
                            this.filters.push(data);
                        }
                    break;
                    case 'max_price':
                        if(this.$router.history.current.query[query]){
                            let dataPrice = {filter: 'price',val: `S/ ${this.$router.history.current.query['min_price']} - S/ ${this.$router.history.current.query[query]}`};
                            this.filters.push(dataPrice);
                        }
                    break;
                    case 'search':
                        if(this.$router.history.current.query[query]){
                            let dataS = {filter: query,val: this.$router.history.current.query[query]};
                            this.filters.push(dataS);
                        }
                    break;
                }
            }
        }
    }
};
</script>
