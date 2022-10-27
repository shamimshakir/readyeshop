<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>Sales Return Reports</h3>
            <form id="reportForm" class="form-group" @submit.prevent="searchSales($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>Status</label>
                        <select class="form-control" v-model="salesSearch.status">
                            <option value="">Select a Status</option>
                            <option v-for="ordersts in orderStatuses"  :value="ordersts.id" :key="ordersts.id">{{ ordersts.ord_status }}</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Customer</label>
                        <select class="form-control" v-model="salesSearch.customer_id">
                            <option value="">Select Customer</option>
                            <option v-for="customer in customers" :value="customer.id" :key="customer.id">
                                {{ customer.firstname }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="salesSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label for="txttorec_date">To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="salesSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>Order No</label>
                        <input type="text" placeholder="Order No" v-model="salesSearch.order_no" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="sales.length > 0">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Order Date</th>
                        <th>Customer</th>
                        <th>Order Status</th>
                        <th>Order Item</th>
                        <th>Payment Status</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" :key="sale.id">
                        <td>{{ sale.od_no }}</td>
                        <td>{{ new Date(sale.od_date).toLocaleDateString() }}</td>
                        <td>{{ sale.od_payment_first_name }}</td>
                        <td>{{ sale.orderstatus.ord_status }}</td>
                        <td>{{ sale.orderitems.length }}</td>
                        <td>{{ sale.payment_status == 1 ? "paid": "unpaid" }}</td>
                        <td>{{ sale.total_cost }}</td>
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
            customers: [],
            sales: [],
            orderStatuses: [],
            salesSearch: {
                status: "",
                customer_id: "",
                start_date: "",
                end_date: "",
                order_no: ""
            },
        };
    },
    created() {
        this.getCustomers();
        this.getOrderStatuses();
    },
    mounted() {

    },
    methods: {
        async getOrderStatuses() {
            let data = await this.$root.getAllData("/api/user/orderStatus");
            this.orderStatuses = data.filter(item => item.id == 5 || item.id == 4);
        },
        async getCustomers() {
            this.customers = await this.$root.getAllData("/api/user/customers");
        },
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        searchSales() {
            this.salesSearch.start_date = this.formatDate(this.salesSearch.start_date);
            this.salesSearch.end_date = this.formatDate(this.salesSearch.end_date);
            this.loading = true;
            this.$root.addData(this.salesSearch, '/api/user/report/salesreturn').then(response => {
                this.sales = response.data.data;
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
