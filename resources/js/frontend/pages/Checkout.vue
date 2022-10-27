<template>
<div>
    <Header />
    <Breadcrumbs title="Checkout" />
    <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                                <div class="checkout-title">
                                    <h3>Billing Details</h3>
                                </div>
                                <div class="row check-out">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Name</div>
                                        <input type="text" v-model="orderInfo.od_payment_first_name" />
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Phone</div>
                                        <input type="text" v-model="orderInfo.od_payment_phone" />
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Email Address</div>
                                        <input type="email" v-model="orderInfo.od_payment_email" />
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Country</div>
                                        <select v-model="orderInfo.od_payment_country" @change="getCities($event)">
                                            <option disabled value="0">Select Country</option>
                                            <option v-for="country in countries" :value="country.id" :key="country.id">
                                                {{ country.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">City</div>
                                        <select v-model="orderInfo.od_payment_city" @change="getThanas($event)">
                                            <option disabled value="0">Select City</option>
                                            <option v-for="city in cities" :value="city.id" :key="city.id">
                                                {{ city.location }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Thana</div>
                                        <select v-model="orderInfo.od_payment_thana">
                                            <option disabled value="0">Select Thana</option>
                                            <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                                {{ thana.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Address</div>
                                        <input type="text" v-model="orderInfo.od_payment_address1" />
                                    </div>
                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">Postal Code</div>
                                        <input type="text" v-model="orderInfo.od_payment_postal_code" />
                                    </div>
                                </div>
                                <p id="ship-to-different-address" class="my-4 pl-2">
                                    <label>Ship to a different address?</label>
                                    <input type="checkbox" v-model="showShippingAddress" />
                                </p>
                                <div class="shippingAddressArea" v-if="showShippingAddress">
                                    <div class="checkout-title">
                                        <h3>Shipping Details</h3>
                                    </div>
                                    <div class="row check-out mt-5">
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Name</div>
                                            <input type="text" v-model="orderInfo.od_shipping_first_name" />
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Phone</div>
                                            <input type="text" v-model="orderInfo.od_shipping_phone" />
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Email Address</div>
                                            <input type="email" v-model="orderInfo.od_shipping_email" />
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Country</div>
                                            <select v-model="orderInfo.od_shipping_country" @change="getCities($event)">
                                                <option disabled value="0">Select Country</option>
                                                <option v-for="country in countries" :value="country.id" :key="country.id">
                                                    {{ country.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">City</div>
                                            <select v-model="orderInfo.od_shipping_city" @change="getThanas($event)">
                                                <option disabled value="0">Select City</option>
                                                <option v-for="city in cities" :value="city.id" :key="city.id">
                                                    {{ city.location }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                            <div class="field-label">Thana</div>
                                            <select v-model="orderInfo.od_shipping_thana">
                                                <option disabled value="0">Select Thana</option>
                                                <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                                    {{ thana.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-label">Address</div>
                                            <input type="text" v-model="orderInfo.od_shipping_address1" />
                                        </div>
                                        <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                            <div class="field-label">Postal Code</div>
                                            <input type="text" v-model="orderInfo.od_shipping_postal_code" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>
                                                Product
                                                <span>Total</span>
                                            </div>
                                        </div>
                                        <ul class="qty mb-3" v-if="cartItems && cartItems.length">
                                            <li v-for="(cart, index) in cartItems" :key="index">
                                                {{ cart.products.pd_name }} X {{ cart.ct_qty }}
                                                <span>{{ currency }}{{ cart.price }}</span>
                                            </li>
                                        </ul>
                                        <ul class="sub-total mb-3">
                                            <li>
                                                Subtotal
                                                <span class="count">{{ cartTotal }}</span>
                                            </li>
                                            <!-- <li>
                          Shipping
                          <div class="shipping">
                            <div class="shopping-option">
                              <input
                                type="checkbox"
                                name="free-shipping"
                                id="free-shipping"
                              />
                              <label for="free-shipping">Free Shipping</label>
                            </div>
                            <div class="shopping-option">
                              <input
                                type="checkbox"
                                name="local-pickup"
                                id="local-pickup"
                              />
                              <label for="local-pickup">Local Pickup</label>
                            </div>
                          </div>
                        </li> -->
                                        </ul>
                                        <ul class="sub-total mb-3">
                                            <li>
                                                Total
                                                <span class="count">{{ cartTotal }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                                <ul v-for="(paymentoprion, index) in paymentoprions" :key="index">
                                                    <li>
                                                        <div class="radio-option">
                                                            <input type="radio" v-model="orderInfo.order_payment_method" name="payment-group" :value="paymentoprion.name"  :id="'payment-' + index"   />
                                                            <label :for="'payment-' + index" >
                                                              <span v-if="paymentoprion.name=='cod'">
                                                                  Cash On Delivery
                                                              </span>  
                                                              <span v-else-if="paymentoprion.name=='ssl'">
                                                                  Online Payment
                                                              </span>  
                                                              <span v-else>
                                                                  {{paymentoprion.name}}
                                                              </span> 
                                                            </label>
                                                        </div>
                                                    </li>
                                                   <!--  <li>
                                                        <div class="radio-option">
                                                            <input type="radio" v-model="orderInfo.order_payment_method" name="payment-group" checked="checked" value="ssl" id="payment-2" />
                                                            <label for="payment-2">
                                                                Online Payment
                                                            </label>
                                                        </div>
                                                    </li> -->
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button v-if="orderInfo.order_payment_method === 'cod'" type="submit" class="btn-solid btn">
                                                Place Order
                                            </button>
                                            <button v-if="orderInfo.order_payment_method === 'ssl'" type="submit" class="btn-solid btn">
                                                Pay Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</div>
</template>

<script>
import Breadcrumbs from "../components/widgets/breadcrumbs";
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
export default {
    components: {
        Breadcrumbs,
        Header,
		Footer,
    },
    computed: {
        currency() {
            return this.$store.state.siteCurrency;
        },
        cartItems() {
            return this.$store.getters.cartProducts;
        },
        cartTotal() {
            return this.$store.getters.cartTotal;
        },
        token() {
            return this.$store.state.token;
        }
    },

    data() {
        return {
            loading: false,
            orderInfo: {
                od_payment_country: 0,
                od_payment_city: 0,
                od_payment_thana: 0,
                od_shipping_cost: 0,
                order_payment_method: 'ssl',
            },
            isLogin: false,
            countries: [],
            cities: [],
            thanas: [],
            paymentoprions:[],
            showShippingAddress: false,
            button_style: {
                label: "checkout",
                size: "medium", // small | medium | large | responsive
                shape: "pill", // pill | rect
                color: "blue", // gold | blue | silver | black
            },
            amtchar: "",
        };
    },
    created() {
        this.getCustomerInfo();
        this.getPaymentOption();
    },
    methods: {
        redirectToPayment() {
            console.log('hello');

        },
        async getCustomerInfo() {
            if (sessionStorage["loginInfo"]) {
                this.loading = true;
                let customerData = await this.$root.getDetailsData({},
                    `/api/customer/getcust`
                );
                let customerInfo = customerData.data.data;
                this.orderInfo.customer__id = customerInfo.id;
                this.orderInfo.od_payment_first_name = customerInfo.firstname;
                this.orderInfo.od_payment_email = customerInfo.email;
                this.orderInfo.od_payment_phone = customerInfo.phone;
                this.orderInfo.od_payment_country = customerInfo.country;
                this.orderInfo.od_payment_address1 = customerInfo.address;
                this.orderInfo.od_payment_postal_code = customerInfo.postal_code;
                this.orderInfo.od_payment_city = customerInfo.city;
                this.orderInfo.od_payment_thana = customerInfo.thana;
                this.orderInfo.od_shipping_first_name = customerInfo.firstname;
                this.orderInfo.od_shipping_email = customerInfo.email;
                this.orderInfo.od_shipping_phone = customerInfo.phone;
                this.orderInfo.od_shipping_address1 = customerInfo.address;
                this.orderInfo.od_shipping_postal_code = customerInfo.postal_code;
                this.orderInfo.od_shipping_country = customerInfo.country;
                this.orderInfo.od_shipping_city = customerInfo.city;
                this.orderInfo.od_shipping_thana = customerInfo.thana;
                Promise.all([
                    this.getAllContries(),
                    this.getCustomerCities(customerInfo.country),
                    this.getCustomerThanas(customerInfo.district),
                ]).then((reses) => {
                    this.countries = reses[0].data.data;
                    this.cities = reses[1].data.data;
                    this.thanas = reses[2].data.data;
                });
                this.getShippingCost(this.orderInfo.od_shipping_city);
                this.loading = false;
            } else {
                this.$router.push("/account/login").catch(() => {});
            }
        },
        async getAllContries() {
            return await this.$root.getFrontData({}, `/api/country_param`);
        },
        async getCustomerCities(id) {
            return await this.$root.getFrontData({
                    country: id,
                },
                `/api/district_param`
            );
        },
        async getShippingCost(id) {
            await this.$root.getFrontData({
                    id: id,
                },
                `/api/shipping_cost`
            ).then(res => {
                this.orderInfo.od_shipping_cost = res.data.data[0].price;
            })
        },
        async getCustomerThanas(id) {
            return await this.$root.getFrontData({
                    district: id,
                },
                `/api/thana_param`
            );
        },
        async getPaymentOption(id) {
            let paymentOpt =  await this.$root.getFrontData({},`/api/payment/param`);
            this.paymentoprions = paymentOpt.data.data;
        },
        getCities(event) {
            let id = event.target.value;
            this.$root
                .getFrontData({
                        country: id,
                    },
                    `/api/district_param`
                )
                .then((res) => {
                    this.cities = res.data.data;
                });
        },
        getThanas(event) {
            let id = event.target.value;
            this.$root
                .getFrontData({
                        district: id,
                    },
                    `/api/thana_param`
                )
                .then((res) => {
                    this.thanas = res.data.data;
                });
        },
        async removeCartItem() {
            this.$store.dispatch("clearCart");
        },
        async onSubmit() {
            let ordFormData = this.orderInfo;
            ordFormData.product_cost = this.cartTotal,
                ordFormData.total_cost = Number(this.cartTotal) + Number(ordFormData.od_shipping_cost),
                ordFormData.pd_id = [];
            ordFormData.od_qty = [];
            ordFormData.size_id = [];
            ordFormData.color_id = [];
            ordFormData.pd_price = [];
            this.cartItems.forEach((row, index) => {
                ordFormData.pd_id[index] = row.pd_id;
                ordFormData.od_qty[index] = row.ct_qty;
                ordFormData.size_id[index] = row.size_id || "";
                ordFormData.color_id[index] = row.color_id || "";
                ordFormData.pd_price[index] = row.products.pd_price;
            });
            if (ordFormData.order_payment_method === 'ssl') {
                localStorage.setItem('order__info', JSON.stringify(ordFormData));
                window.location.href = `${document.location.origin}/payment`;
            } else if (ordFormData.order_payment_method === 'cod') {
                await this.$root
                    .getDetailsData(ordFormData, `/api/customer/order/store`)
                    .then((result) => {
                        this.removeCartItem();
                        Vue.$toast.open({
                            message: result.data.message,
                            position: "top-right",
                            type: "success",
                            duration: 3000,
                            dismissible: false,
                        });
                        this.$router.push({
                            name: 'ordersuccess',
                            params: {
                                order_id: result.data.Order
                            }
                        });
                    })
                    .catch((err) => {
                        console.log('niche')
                        console.dir(err)
                        Vue.$toast.open({
                            message: "Failed to order",
                            position: "top-right",
                            type: "error",
                            duration: 3000,
                            dismissible: false,
                        });
                    });
            }
        },
    },
};
</script>
