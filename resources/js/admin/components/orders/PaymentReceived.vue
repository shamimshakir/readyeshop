
<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <div class="card-body">
                <form @submit.prevent="receivePayment($event)">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="payment_status">Payment Status </label>
                            <select v-model="orderInfo.payment_status" class='form-control'>
                                <option value="1">Paid</option>
                                <option value="0">Unpaid</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="od_payment_amount">Payment Amount</label>
                            <input v-model="orderInfo.od_payment_amount" class="form-control" placeholder="Payment Amount" />
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-0 d-flex justify-content-end">
                        <div>
                            <router-link to="orders" class="btn btn-warning btns-m">Back</router-link>
                            <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            orderInfo: {
                payment_status: "1",
                id: this.$route.params.id,
                od_payment_amount: ""
            },
        }
    },
    created() {
    },
    methods: {
        receivePayment(e){
            this.$root.addData(this.orderInfo, '/api/user/orders/receive_payment').then(response => {
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
                this.$fire({
                    title: "Failed to Update",
                    type: "warning",
                    timer: 2000
                });
            });
        },
    }
}
</script>
