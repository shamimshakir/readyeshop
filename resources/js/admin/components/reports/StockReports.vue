<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>Stock Reports</h3>
            <form id="reportForm" class="form-group" @submit.prevent="searchStock($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>Select Category </label>
                        <select v-model="stockSearch.cat_id" class="form-control" @change="getProducts($event)">
                            <option value="">Select Category</option>
                            <option v-for="category in categories" :value="category.id" :key="category.id">
                                {{ category.cat_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Select Product </label>
                        <select v-model="stockSearch.pd_id" class="form-control">
                            <option value="">Select a Product</option>
                            <option v-for="product in products" :value="product.id" :key="product.id">
                                {{ product.pd_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Select Status </label>
                        <select class="form-control" v-model="stockSearch.stat_id">
                            <option value="">Select Status</option>
                            <option value="1">Active</option>
                            <option value="2">Inctive</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="allStocks.length > 0">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="stock in allStocks" :key="stock.id">
                        <td>{{ stock.pd_name }}</td>
                        <td>{{ stock.category.cat_name }}</td>
                        <td>{{ stock.brand.brand_display }}</td>
                        <td v-if="stock.unit">{{ stock.unit.unit_display }}</td>
                        <td>{{ stock.pd_price }}</td>
                        <td>{{ stock.pd_qty }}</td>
                        <td>{{ stock.status.stat_desc }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="mb-5 pt-5 pb-5"></div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    components: {

    },
    data() {
        return {
            loading: false,
            allStocks: [],
            stockSearch: {
                cat_id: "",
                stat_id: "",
                pd_id: "",
            },
            categories: [],
            products: [],
        }
    },
    created() {
        this.getAllCategories();
    },
    mounted() {

    },
    methods: {
        async getAllCategories() {
            this.categories = await this.$root.getAllData("/api/user/categories");
        },
        async getProducts(e) {
            this.products = await this.$root.getAllData(`/api/user/products/showbycatagory/${e.target.value}`);
        },
        searchStock() {
            this.loading = true;
            this.$root.addData(this.stockSearch, '/api/user/report/productstock').then(response => {
                this.allStocks = response.data.data;
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
