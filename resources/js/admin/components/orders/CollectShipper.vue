<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div v-bind:class="{ lessOpacity: loading }">
                <h5>Order No Ready</h5>
                <form @submit.prevent="OrderReady($event)">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="shipper_remark">Shipper Remark</label>
                            <input v-model="orderInfo.shipper_remark" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <label for="shipper_collect">Shipper Collect</label>
                            <input v-model="orderInfo.shipper_collect" class="form-control" />
                        </div>
                        <div class="col-md-12">
                            <label for="traking_id">Tracking ID</label>
                            <textarea v-model="orderInfo.traking_id" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-0 d-flex justify-content-end">
                        <div>
                            <router-link to="orders" class="btn btn-warning btns-m">Back</router-link>
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                        </div>
                    </div>
                </form>
                <h5>History</h5>
                <table class="table table-bordered table-conenced">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Comments</th>
                            <th>Change Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="history in customer.orderhistorys">
                            <td>{{ history.orderhistorystatus.ord_status }}</td>
                            <td>{{ history.comments }}</td>
                            <td>{{ history.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            orderInfo: {
                od_status: "8",
                id: this.$route.params.id,
                traking_id: "",
                shipper_remark: "",
                shipper_collect: "",
            },
            customer: {},
            loading: false,
        }
    },
    created() {
        this.getOrderDatas();
    },
    methods: {
        OrderReady(e) {
            this.$root.addData(this.orderInfo, '/api/user/orders/shipment_collect').then(response => {
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
                console.dir(res);
                this.$fire({
                    title: "Failed to Update",
                    type: "warning",
                    timer: 2000
                });
            });
        },
        async getOrderDatas() {
            this.loading = true;
            let data = await this.$root.getAllData(`/api/user/orders/${this.$route.params.id}`);
            this.customer = data[0];
            this.loading = false;
        },
    }
}
</script>
