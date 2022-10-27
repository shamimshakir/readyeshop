<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Product Receive" btnRoute="new_product_purchase" btnName="Add New" :menu_name="routeName" />
        <div class="card-body">
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
                        <select v-model="productsSearch.product" class="form-control">
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

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Client</th>
                        <th>Total Bill</th>
                        <th>Entry Date</th>
                        <th>Update Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products" :key="product.id">
                        <td>{{ product.invoice_number }}</td>
                        <td>{{ new Date(product.invoice_date).toLocaleDateString() }}</td>
                        <td>{{ product.vendor.vendor_name }}</td>
                        <td>{{ product.total_bill }}</td>
                        <td>{{ new Date(product.created_at ).toLocaleDateString() }}</td>
                        <td>{{ new Date(product.updated_at ).toLocaleDateString() }}</td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_product_purchase', params: { id: product.id }}" class="btn btn-info btn-sm">Edit</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        CardHeader,
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
        this.getDefaultProducts();
    },
    mounted() {

    },
    computed: {
        routeName() {
            return this.$route.name;
        }
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
        async getDefaultProducts() {
            this.loading = true;
            this.products = await this.$root.getAllData("/api/user/productreceives");
            this.loading = false;
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
