<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                    <form @submit.prevent="addProductPurchase($event)">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Select Vendor <span class="text-danger">*</span></label>
                                <select :class="
                                    !isEmpty(errors) && !ppurchase.client_id
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="ppurchase.client_id">
                                    <option disabled value="">Select Vendor</option>
                                    <option v-for="vendor in vendors" :value="vendor.id" :key="vendor.id">
                                        {{ vendor.vendor_name }}
                                    </option>
                                </select>
                                <p class="text-danger" v-if="errors.client_id.length > 0 && !ppurchase.client_id" v-for="client_id in errors.client_id">
                                    {{ client_id }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Received Date <span class="text-danger">*</span></label>
                                <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="ppurchase.invoice_date"></datepicker>
                                <p class="text-danger" v-if="errors.invoice_date.length > 0 && !ppurchase.invoice_date" v-for="invoice_date in errors.invoice_date">
                                    {{ invoice_date }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <label>Comments <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Comments" v-model="ppurchase.comments"/>
                            </div>
                        </div>
                        <table class="table table-bordered bg-light mt-3 table-sm">
                            <thead>
                                <tr>
                                    <th>Category <span style="color:red;">*</span></th>
                                    <th>Product <span style="color:red;">*</span></th>
                                    <th>Size <span style="color:red;">*</span></th>
                                    <th>Color <span style="color:red;">*</span></th>
                                    <th>Quantity <span style="color:red;">*</span></th>
                                    <th>Price <span style="color:red;">*</span></th>
                                    <th>Total</th>
                                    <th>
                                        <button type="button" @click="addRow()" class="btn btn-sm btn-info float-right">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row, index) in rows" :key="row.id">
                                    <td>
                                        <select class="form-control" @change="getProducts(row.id, $event)" v-model="row.selectedCategory">
                                            <option value="">Select a Category</option>
                                            <option v-for="category in row.categories" :value="category.id" :key="category.id">
                                                {{ category.cat_name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" @change="getColorsNsizes(row.id, $event)" v-model="row.selectedProduct">
                                            <option value="">Select a Product</option>
                                            <option v-for="product in row.products" :value="product.id" :key="product.id">
                                                {{ product.pd_name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" v-model="row.selectedSize">
                                            <option value="0">No Size</option>
                                            <option v-for="size in row.sizes" :value="size.size_id" :key="size.id">
                                                {{ size.size.size_display }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" v-model="row.selectedColor">
                                            <option value="0">No color</option>
                                            <option v-for="color in row.colors" :value="color.color_id" :key="color.id">
                                                {{ color.color.color_name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="row.selectedQty">
                                    </td>
                                    <td>
                                        <input type="text" v-model="row.unitPrice" class="form-control">
                                    </td>
                                    <td>
                                        {{ row.selectedQty && row.unitPrice && (Number(row.selectedQty) * Number(row.unitPrice)) }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="removeRow(row.id)"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Total Cost</strong></td>
                                    <td><strong>{{ totalCost && totalCost }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <router-link to="/orders" class="btn btn-secondary waves-effect">Back</router-link>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
            rows: [{
                id: 1,
                categories: []
            }],
            vendors: [],
            categories: [],
            colors: [],
            errors: [],
            sizes: [],
            products: [],
            ppurchase: {
                client_id: "",
            },
            loading: false,
            productCost: 0,
            totalCost: 0,
        }
    },
    created() {
        this.getVendorsNProductInfos();
    },
    updated() {
        this.getProdcutCost()
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        getProdcutCost() {
            let total = 0;
            this.rows.forEach(row => {
                let rowTotal = 0;
                rowTotal = Number(row.selectedQty) * Number(row.unitPrice);
                total += rowTotal;
            });
            if (total) {
                this.productCost = total;
                this.totalCost = this.productCost
            }
        },
        addRow() {
            let obj = {
                id: new Date().getUTCMilliseconds(),
                categories: this.categories,
            };
            this.rows.push(obj);
        },
        removeRow(id) {
            if (this.rows.length > 1) {
                let newRows = this.rows.filter((item, indx) => {
                    if (item.id != id) {
                        return item;
                    }
                });
                this.rows = newRows;
            }
        },
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        addProductPurchase(e) {
            this.ppurchase.invoice_date = this.formatDate(this.ppurchase.invoice_date);
            let ppurchaseFormData = this.ppurchase;
            ppurchaseFormData.cat_id = [];
            ppurchaseFormData.prod_id = [];
            ppurchaseFormData.size_id = [];
            ppurchaseFormData.color_id = [];
            ppurchaseFormData.qty = [];
            ppurchaseFormData.unitprice = [];
            ppurchaseFormData.total = [];
            this.rows.forEach((row, index) => {
                ppurchaseFormData.cat_id[index] = row.selectedCategory;
                ppurchaseFormData.prod_id[index] = row.selectedProduct;
                ppurchaseFormData.size_id[index] = row.selectedSize;
                ppurchaseFormData.color_id[index] = row.selectedColor;
                ppurchaseFormData.qty[index] = row.selectedQty;
                ppurchaseFormData.unitprice[index] = row.unitPrice;
                ppurchaseFormData.total[index] = row.selectedQty * row.unitPrice;
            });
            this.$root.addData(ppurchaseFormData, '/api/user/productreceives').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "product_purchase",
                });
                e.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Create",
                        type: "warning",
                        timer: 2000
                    });
                }
            });
        },
        async getVendorsNProductInfos() {
            this.loading = true;
            this.vendors = await this.$root.getAllData('/api/user/vendors');
            this.categories = await this.$root.getAllData("/api/user/categories");
            this.rows[0].categories = this.categories;
            this.loading = false;
        },
        async getProducts(id, e) {
            let data = await this.$root.getAllData(`/api/user/products/showbycatagory/${e.target.value}`);
            this.rows = this.rows.map(row => {
                if (row.id == id) {
                    row.products = data;
                }
                return row;
            });
        },
        getColorsNsizes(id, e) {
            this.rows = this.rows.map(row => {
                if (row.id == id) {
                    row.products.forEach(product => {
                        if (product.id == e.target.value) {
                            row.colors = product.productcolors;
                            row.sizes = product.productsizes;
                            row.unitPrice = product.pd_price;
                        }
                    });
                }
                return row;
            });
        },
    },
};
</script>

<style scoped>

</style>
