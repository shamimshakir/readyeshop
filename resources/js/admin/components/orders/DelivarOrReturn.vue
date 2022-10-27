<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <div v-bind:class="{ lessOpacity: loading }">
                    <form @submit.prevent="DelivarOrCancel($event)">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="od_status">Order Status </label>
                                <select v-model="orderInfo.od_status" class='form-control'>
                                    <option value="">Select a Order</option>
                                    <option v-for="sts in status" :value="sts.id" :key="sts.id">{{ sts.ord_status }}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="od_status">Status Change Comment</label>
                                <textarea v-model="orderInfo.status_change_comment" rows="5" class="form-control"></textarea>
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
    data(){
        return {
            orderInfo: {
                od_status: "",
                id: this.$route.params.id,
                status_change_comment: ""
            },
            status: [],
            customer: {},
            loading: false,
        }
    },
    created() {
        this.getOrderDatas();
    },
    methods: {
        DelivarOrCancel(e){
            this.$root.addData(this.orderInfo, '/api/user/orders/order_deliver').then(response => {
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
                // console.dir(res);
                this.$fire({
                    title: "Failed to Update",
                    type: "warning",
                    timer: 2000
                });
            });
        },
        async getOrderDatas() {
            this.loading = true;
            let sts = await this.$root.getAllData("/api/user/orderStatus");
            this.status = sts.filter(item => {
                if(item.id == 3 || item.id == 4){
                    return item;
                }
            })
            let data = await this.$root.getAllData(`/api/user/orders/${this.$route.params.id}`);
            this.customer = data[0];
            this.loading = false;
        },
    }
}
</script>
