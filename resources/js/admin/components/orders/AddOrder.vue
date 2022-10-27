<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                    <form @submit.prevent="addOrder($event)">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="firstname">Select Customer <span class="text-danger">*</span></label>
                                <select :class="
                                    !isEmpty(errors) && !selectedCustomer
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="selectedCustomer" @change="getCustomerInfo($event)">
                                    <option disabled value="">Select Customer</option>
                                    <option v-for="customer in customers" :value="customer.id" :key="customer.id">
                                        {{ customer.firstname }}
                                    </option>
                                </select>
                                <p class="text-danger" v-if="errors.cl_id.length > 0 && !selectedCustomer" v-for="cl_id in errors.cl_id">
                                    {{ cl_id }}
                                </p>
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
                                        <select class="form-control" @change="getProducts(row.id, $event)">
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
                                            <option value="">No Size</option>
                                            <option v-for="size in row.sizes" :value="size.size_id" :key="size.id">
                                                {{ size.size.size_display }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control" v-model="row.selectedColor">
                                            <option value="">No Color</option>
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
                                    <td colspan="6" class="text-right"><strong>Shipping Cost</strong></td>
                                    <td><strong>{{ shippingCost }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"><strong>Total Cost</strong></td>
                                    <td><strong>{{ totalCost && totalCost }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-bind:class="{ lessOpacity: loading }">
                            <h5>Billing Address</h5>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Name </label>
                                        <input type="text" class="form-control" v-model="orderInfo.od_payment_first_name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" v-model="orderInfo.od_payment_email">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Phone </label>
                                        <input type="text" class="form-control" v-model="orderInfo.od_payment_phone">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Country </label>
                                        <select class="form-control" v-model="orderInfo.od_payment_country" @change="getCities($event)">
                                            <option disabled value="0">Select Country</option>
                                            <option v-for="country in countries" :value="country.id" :key="country.id">
                                                {{ country.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="country">City </label>
                                        <select class="form-control" v-model="orderInfo.od_payment_city" @change="getThanas($event)">
                                            <option disabled value="0">Select City</option>
                                            <option v-for="city in cities" :value="city.id" :key="city.id">
                                                {{ city.location }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="thana">Thana </label>
                                        <select class="form-control">
                                            <option disabled value="0">Select Thana</option>
                                            <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                                {{ thana.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Address </label>
                                    <input type="text" class="form-control" v-model="orderInfo.od_payment_address1">
                                </div>
                                <div class="col-lg-4">
                                    <label>Street</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-lg-4">
                                    <label>Postcode / ZIP </label>
                                    <input type="text" class="form-control" v-model="orderInfo.od_payment_postal_code">
                                </div>
                            </div>
                            <h5>Shipping Address</h5>
                            <p id="ship-to-different-address">
                                <label>Ship to a different address?</label>
                                <input type="checkbox" v-model="showShippingAddress">
                            </p>
                            <div class="row mt-3 mb-3" v-if="showShippingAddress">
                                <div class="col-lg-4">
                                    <label>Name <span style="color:red;">*</span></label>
                                    <input type="text" :class="
                                        !isEmpty(errors) && !orderInfo.od_shipping_first_name
                                        ? 'form-control border-danger'
                                        : 'form-control'
                                    " v-model="orderInfo.od_shipping_first_name">
                                    <p class="text-danger" v-if="
                                                errors.od_shipping_first_name.length > 0 && !orderInfo.od_shipping_first_name
                                            " v-for="od_shipping_first_name in errors.od_shipping_first_name">
                                        {{ od_shipping_first_name }}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <label>Email Address <span style="color:red;">*</span></label>
                                    <input type="email" :class="
                                        !isEmpty(errors) && !orderInfo.od_shipping_email
                                        ? 'form-control border-danger'
                                        : 'form-control'
                                    " v-model="orderInfo.od_shipping_email">
                                    <p class="text-danger" v-if="
                                                errors.od_shipping_email.length > 0 && !orderInfo.od_shipping_email
                                            " v-for="od_shipping_email in errors.od_shipping_email">
                                        {{ od_shipping_email }}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <label>Phone <span style="color:red;">*</span></label>
                                    <input type="text" :class="
                                        !isEmpty(errors) && !orderInfo.od_shipping_phone
                                        ? 'form-control border-danger'
                                        : 'form-control'
                                    " v-model="orderInfo.od_shipping_phone">
                                    <p class="text-danger" v-if="
                                                errors.od_shipping_phone.length > 0 && !orderInfo.od_shipping_phone
                                            " v-for="od_shipping_phone in errors.od_shipping_phone">
                                        {{ od_shipping_phone }}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Country </label>
                                        <select :class="
                                            !isEmpty(errors) && !orderInfo.od_shipping_country
                                            ? 'form-control border-danger'
                                            : 'form-control'
                                        " v-model="orderInfo.od_shipping_country" @change="getCities($event)">
                                            <option disabled value="0">Select Country</option>
                                            <option v-for="country in countries" :value="country.id" :key="country.id">
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <p class="text-danger" v-if="
                                                errors.od_shipping_country.length > 0 && !orderInfo.od_shipping_country
                                                " v-for="od_shipping_country in errors.od_shipping_country">
                                            {{ od_shipping_country }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="country">City </label>
                                        <select class="form-control" v-model="orderInfo.od_shipping_city" @change="getThanas($event)">
                                            <option disabled value="0">Select City</option>
                                            <option v-for="city in cities" :value="city.id" :key="city.id">
                                                {{ city.location }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="thana">Thana </label>
                                        <select class="form-control" v-model="orderInfo.od_shipping_thana">
                                            <option disabled value="0">Select Thana</option>
                                            <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                                {{ thana.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label>Address <span style="color:red;">*</span></label>
                                    <input type="text" :class="
                                        !isEmpty(errors) && !orderInfo.od_shipping_address1
                                        ? 'form-control border-danger'
                                        : 'form-control'
                                    " v-model="orderInfo.od_shipping_address1">
                                    <p class="text-danger" v-if="
                                                errors.od_shipping_address1.length > 0 && !orderInfo.od_shipping_address1
                                            " v-for="od_shipping_address1 in errors.od_shipping_address1">
                                        {{ od_shipping_address1 }}
                                    </p>
                                </div>
                                <div class="col-lg-4">
                                    <label>Street</label>
                                    <input type="text" class="form-control" v-model="orderInfo.od_shipping_address2">
                                </div>
                                <div class="col-lg-4">
                                    <label>Postcode / ZIP</label>
                                    <input type="text" :class="
                                        !isEmpty(errors) && !orderInfo.od_shipping_postal_code
                                        ? 'form-control border-danger'
                                        : 'form-control'
                                    " v-model="orderInfo.od_shipping_postal_code">
                                    <p class="text-danger" v-if="
                                                errors.od_shipping_postal_code.length > 0 && !orderInfo.od_shipping_postal_code
                                            " v-for="od_shipping_postal_code in errors.od_shipping_postal_code">
                                        {{ od_shipping_postal_code }}
                                    </p>
                                </div>
                            </div>
                            <input type="radio" v-model="orderInfo.order_payment_method" value="cod" class="input-radio">
                            <label>Cash on Delivery</label>
                            <p class="text-danger" v-if="
                                                errors.order_payment_method.length > 0 && !orderInfo.order_payment_method
                                            " v-for="order_payment_method in errors.order_payment_method">
                                {{ order_payment_method }}
                            </p>
                        </div>
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
export default {
    data() {
        return {
            rows: [{
                id: 1,
                categories: []
            }],
            customers: [],
            selectedCustomer: "",
            categories: [],
            colors: [],
            countries: [],
            cities: [],
            thanas: [],
            errors: [],
            showShippingAddress: false,
            sizes: [],
            products: [],
            orderInfo: {
                order_payment_method: 'cod',
            },
            loading: false,
            productCost: 0,
            totalCost: 0,
            shippingCost: 50,
        }
    },
    created() {
        this.getCustomersNProductInfos();
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
                this.totalCost = this.productCost + this.shippingCost;
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
        addOrder(e) {
            let ordFormData = this.orderInfo;
            ordFormData.cl_id = this.selectedCustomer;
            ordFormData.product_cost = this.productCost;
            ordFormData.total_cost = this.totalCost;
            ordFormData.od_shipping_cost = this.shippingCost;
            ordFormData.pd_id = [];
            ordFormData.od_qty = [];
            ordFormData.size_id = [];
            ordFormData.color_id = [];
            ordFormData.pd_price = [];
            this.rows.forEach((row, index) => {
                ordFormData.pd_id[index] = row.selectedProduct;
                ordFormData.od_qty[index] = row.selectedQty;
                ordFormData.size_id[index] = row.selectedSize;
                ordFormData.color_id[index] = row.selectedColor;
                ordFormData.pd_price[index] = row.unitPrice;
            });
            this.$root.addData(ordFormData, '/api/user/orders').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "orders",
                });
                e.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Create Order",
                        type: "warning",
                        timer: 2000
                    });
                }
            });
        },
        async getCustomersNProductInfos() {
            this.loading = true;
            this.customers = await this.$root.getAllData('/api/user/customers');
            this.categories = await this.$root.getAllData("/api/user/categories");
            this.rows[0].categories = this.categories;
            this.getAllContries().then((res) => {
                this.countries = res;
                this.loading = false;
            });
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
        async getAllContries() {
            return await this.$root.getAllData(
                "/api/user/countries"
            );
        },
        async getCustomerCity(id) {
            return await this.$root.getAllData(
                `/api/user/districts/showByCountrys/${id}`
            );
        },
        async getCustomerThana(id) {
            return await this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
            );
        },
        getCities(event) {
            let id = event.target.value;
            this.$root.getAllData(
                `/api/user/districts/showByCountrys/${id}`
            ).then(res => {
                this.cities = res;
            });
        },

        getThanas(event) {
            let id = event.target.value;
            this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
            ).then(res => {
                this.thanas = res;
            })
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
        getCustomerInfo(e) {
            this.loading = true;
            this.$root.getAllData(
                `/api/user/customers/${e.target.value}`
            ).then(res => {
                this.orderInfo.od_payment_first_name = res[0].firstname;
                this.orderInfo.od_payment_email = res[0].email;
                this.orderInfo.od_payment_phone = res[0].phone;
                this.orderInfo.od_payment_country = res[0].country;
                this.orderInfo.od_payment_address1 = res[0].address;
                this.orderInfo.od_payment_postal_code = res[0].postal_code;
                this.orderInfo.od_payment_city = res[0].city;
                this.orderInfo.od_shipping_first_name = res[0].firstname;
                this.orderInfo.od_shipping_email = res[0].email;
                this.orderInfo.od_shipping_phone = res[0].phone;
                this.orderInfo.od_shipping_address1 = res[0].address;
                this.orderInfo.od_shipping_address2 = res[0].street;
                this.orderInfo.od_shipping_postal_code = res[0].postal_code;
                this.orderInfo.od_shipping_country = res[0].country;
                this.orderInfo.od_shipping_city = res[0].city;
                this.orderInfo.od_shipping_thana = res[0].thana;

                Promise.all([
                    this.getCustomerCity(res[0].country),
                    this.getCustomerThana(res[0].city),
                ]).then(res2 => {
                    this.cities = res2[0];
                    this.thanas = res2[1];
                    this.loading = false;
                });

            });

        }
    },
};
</script>

<style scoped>

</style>
