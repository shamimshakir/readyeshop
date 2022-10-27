<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple  v-if="loading" scale="1.5" color="#3f51b5"/>
            <div class="row" v-bind:class="{ lessOpacity: loading }">
                <div class="col-12">
                    <div class="invoice-title">
                        <h4 class="float-right font-16"><strong>Order No. {{ customer.od_no }}</strong></h4>
                        <h3 class="mt-0">
                            Nextstore
                        </h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                {{ customer.od_payment_first_name }} {{ customer.od_payment_last_name }} <br>
                                {{ customer.od_payment_email }}<br>
                                {{ customer.od_payment_phone }}<br>
                                {{ customer.od_payment_address1 }} </address>
                        </div>
                        <div class="col-6 text-right">
                            <address>
                                <strong>Shipped To:</strong><br>
                                {{ customer.od_shipping_first_name }} {{ customer.od_shipping_last_name }}<br>
                                {{ customer.od_shipping_email }}<br>
                                {{ customer.od_shipping_phone }}<br>
                                {{ customer.od_shipping_address1 }} </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 m-t-30">
                            <address>
                                <strong>Payment Method:</strong><br>
                                {{ customer.order_payment_method }} </address>
                        </div>
                        <div class="col-6 m-t-30 text-right">
                            <address>
                                <strong>Order Date:</strong><br>
                                {{ new Date(customer.od_date).toLocaleDateString() }}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" v-bind:class="{ lessOpacity: loading }">
                <div class="col-12">
                    <div>
                        <div class="p-2">
                            <h3 class="font-16"><strong>Order summary</strong></h3>
                        </div>
                        <div class="">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td><strong>Item</strong></td>
                                            <td class="text-center"><strong>Price</strong></td>
                                            <td class="text-center"><strong>Quantity</strong>
                                            </td>
                                            <td class="text-right"><strong>Totals</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in customer.orderitems">
                                            <td>{{ item.product.pd_name }}</td>
                                            <td class="text-center"> {{ item.pd_price }}</td>
                                            <td class="text-center">{{ item.od_qty }}</td>
                                            <td class="text-right"> {{ item.pd_price * item.od_qty }}</td>
                                        </tr>
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">{{ customer.product_cost }}</td>
                                        </tr>
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Shipping</strong></td>
                                            <td class="thick-line text-right">{{ customer.od_shipping_cost }}</td>
                                        </tr>
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center">
                                                <strong>Subtotal</strong></td>
                                            <td class="thick-line text-right">{{ customer.total_cost }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <router-link to="orders" class="btn btn-warning btns-m">Back</router-link>
                            </div>
                        </div>
                    </div>
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
            customer: {},
            loading: false,
        }
    },
    created() {
        this.getOrderDetails();
    },
    computed: {
        
    },
    methods: {
        async getOrderDetails() {
            this.loading = true;
            let data = await this.$root.getAllData(`/api/user/orders/${this.$route.params.id}`);
            this.customer = data[0];
            this.loading = false;
        },
    },
};
</script>

<style scoped>

</style>
