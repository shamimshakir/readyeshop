<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Orders" btnRoute="add_order" btnName="New Order" :menu_name="routeName"  />
        <div class="card-body">
            <form id="reportForm" class="form-group" @submit.prevent="searchOrder($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>Status</label>
                        <select class="form-control" v-model="orderSearch.status">
                            <option value="">Select a Status</option>
                            <option v-for="ordersts in orderStatuses"  :value="ordersts.id" :key="ordersts.id">{{ ordersts.ord_status }}</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Customer</label>
                        <select class="form-control" v-model="orderSearch.customer_id">
                            <option value="">Select Customer</option>
                            <option v-for="customer in customers" :value="customer.id" :key="customer.id">
                                {{ customer.firstname }}
                            </option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="orderSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label for="txttorec_date">To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="orderSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>Order No</label>
                        <input type="text" placeholder="Order No" v-model="orderSearch.order_no" class="form-control">
                    </div>
                    <div class="col-lg-2">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <datatable v-bind:class="{ lessOpacity: loading }" class="table table-sm table-bordered mb-0" :columns="columns" :data="orders" :filter="filter" :per-page="25">
            </datatable>

            <datatable-pager class="datatablePagination" v-model="page"></datatable-pager>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import OrderDropButton from "./OrderDropButton";
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        CardHeader,
        OrderDropButton,
        Datepicker
    },
    data() {
        return {
            loading: false,
            showModal: false,
            customers: [],
            orders: [],
            filter: "",
            orderSearch: {
                customer_id: "",
                status: "",
                start_date: "",
                end_date: "",
                order_no: ""
            },
            orderStatuses: [],
            columns: [{
                    label: "#SL",
                    field: "id",
                    align: "center"
                },
                {
                    label: "Order No",
                    field: "od_no"
                },
                {
                    label: "Client",
                    field: "customer.firstname"
                },
                {
                    label: "Payment",
                    align: 'center',
                    representedAs: ({
                        payment_status
                    }) => {
                        if (payment_status == 1) {
                            return `<span class="badge badge-success">Paid</span>`;
                        } else {
                            return `<span class="badge badge-secondary">Due</span>`;
                        }
                    },
                    interpolate: true,
                },
                {
                    label: "Payment Date",
                    align: 'center',
                    representedAs: ({
                        od_payment_date
                    }) => {
                        return od_payment_date && `${new Date(od_payment_date).toLocaleDateString()}`
                    },
                    interpolate: true,
                },
                {
                    label: "Order Date",
                    align: 'center',
                    representedAs: ({
                        od_date
                    }) => {
                        return od_date && `${new Date(od_date).toLocaleDateString()}`
                    },
                    interpolate: true,
                },
                {
                    label: "Ship Date",
                    align: 'center',
                    representedAs: ({
                        ship_date
                    }) => {
                        return ship_date && `${new Date(ship_date).toLocaleDateString()}`
                    },
                    interpolate: true,
                },
                {
                    label: "Order Status",
                    field: "orderstatus.ord_status",
                    align: "center"
                },
                {
                    label: "Order Amount",
                    field: "total_cost",
                    align: "center"
                },
                {
                    field: "id",
                    component: OrderDropButton,
                    label: "Action",
                    align: "center",
                },
            ],
            page: 1,
        };
    },
    created() {
        this.getOrders();
        this.getCustomers();
        this.getOrderStatuses();
    },
    mounted() {

    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getOrders() {
            this.loading = true;
            this.orders = await this.$root.getAllData("/api/user/orders");
            //console.log('=====================');
            //console.dir(this.orders);
            //console.log('=====================');
            this.loading = false;
        },
        async getCustomers() {
            this.customers = await this.$root.getAllData("/api/user/customers");
        },
        async getOrderStatuses() {
            let filterObj = {status:1};
            this.$root.addData(filterObj, "/api/user/orderstatus/param").then(res => {
                this.orderStatuses = res.data.data;
            }).catch(err => {
                 console.dir(err);
            })
        },
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        searchOrder() {
            this.orderSearch.start_date = this.formatDate(this.orderSearch.start_date);
            this.orderSearch.end_date = this.formatDate(this.orderSearch.end_date);
            this.loading = true;
            this.$root.addData(this.orderSearch, '/api/user/orders/search').then(response => {
                this.orders = response.data.data;               
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
