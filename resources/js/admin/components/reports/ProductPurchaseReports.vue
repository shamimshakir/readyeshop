<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>Product Purchase Reports</h3>
            <form id="reportForm" class="form-group" @submit.prevent="searchproducts($event)">
                <div class="row">
                    <div class="col-lg-3">
                        <label>Vendor</label>
                        <select class="form-control" v-model="productsSearch.vendor">
                            <option value="">Select Vendor</option>
                            <option v-for="vendor in vendors" :value="vendor.id" :key="vendor.id">
                                {{ vendor.vendor_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Select Category </label>
                        <select v-model="productsSearch.category" class="form-control" @change="getProducts($event)">
                            <option value="">Select Category</option>
                            <option v-for="category in categories" :value="category.id" :key="category.id">
                                {{ category.cat_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Select Product </label>
                        <select v-model="productsSearch.product" class="form-control" >
                            <option value="">Select a Product</option>
                            <option v-for="catproduct in catproducts" :value="catproduct.id" :key="catproduct.id">
                                {{ catproduct.pd_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="productsSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-3">
                        <label for="txttorec_date">To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="productsSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-3">
                        <label>Bill No</label>
                        <input type="text" placeholder="Bill No" v-model="productsSearch.bill_no" class="form-control">
                    </div>
                    <div class="col-lg-3">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="products.length > 0">
                <thead>
                    <tr>
                        <th>Receive No.</th>
                        <th>Received Date</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id">
                        <td>{{ product.invoice_number }}</td>
                        <td>{{ new Date(product.invoice_date).toLocaleDateString() }}</td>
                        <td>{{ product.trn_mat_receives[0].categories.cat_name }}</td>
                        <td>{{ product.trn_mat_receives[0].products.pd_name }}</td>
                        <td>{{ product.trn_mat_receives[0].colors.color_name }}</td>
                        <td>{{ product.trn_mat_receives[0].sizes.size_display }}</td>
                        <td>{{ product.trn_mat_receives[0].qty }}</td>
                        <td>{{ product.trn_mat_receives[0].products.pd_price }}</td>
                        <td>{{ product.total_bill }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="mb-5 pt-5 pb-5"></div>
        </div>
    </div>
</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        Datepicker
    },
    data() {
        return {
            loading: false,
            vendors: [],
            products: [],
            categories: [],
            catproducts: [],
            productsSearch: {
                vendor: "",
                category: "",
                product: "",
                start_date: "",
                end_date: "",
                bill_no: ""
            },
        };
    },
    created() {
        this.getVendors();
        this.getAllCategories();
    },
    mounted() {

    },
    methods: {
        async getVendors() {
            this.vendors = await this.$root.getAllData("/api/user/vendors");
        },
        async getAllCategories() {
            this.categories = await this.$root.getAllData("/api/user/categories");
        },
        async getProducts(e) {
            this.catproducts = await this.$root.getAllData(`/api/user/products/showbycatagory/${e.target.value}`);
        },
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        searchproducts() {
            this.productsSearch.start_date = this.formatDate(this.productsSearch.start_date);
            this.productsSearch.end_date = this.formatDate(this.productsSearch.end_date);
            this.loading = true;
            this.$root.addData(this.productsSearch, '/api/user/report/productsreceive').then(response => {
                this.products = response.data.data;
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
