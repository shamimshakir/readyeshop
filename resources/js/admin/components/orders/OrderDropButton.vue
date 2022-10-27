<template>
<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <router-link :to="{ name: 'order_details', params: { id: row.id } }" class="dropdown-item">Order Details</router-link>

        <router-link v-if="row.payment_status == 0" :to="{ name: 'payment_received', params: { id: row.id } }" class="dropdown-item">Received Payment</router-link>

        <router-link v-if="((row.od_status == 1 ||row.latest_status.status==1) && orderSt.includes(7))" :to="{ name: 'confirm_order', params: { id: row.id } }" class="dropdown-item">Order Confirm/Cancel</router-link>        

        <router-link v-else-if="((row.od_status == 7 || row.latest_status.status==7) && orderSt.includes(2))" :to="{ name: 'order_ready', params: { id: row.id } }" class="dropdown-item">Order Ready</router-link>

        <router-link v-else-if="((row.od_status == 2 || row.latest_status.status==2 || row.latest_status.status==7) && orderSt.includes(6)) " :to="{ name: 'shiper_imform', params: { id: row.id } }" class="dropdown-item">Inform Shipper</router-link>       

        <router-link v-else-if="((row.od_status == 6 || row.latest_status.status==1 || row.latest_status.status==2 || row.latest_status.status==7) && orderSt.includes(8))" :to="{ name: 'collect_shipper', params: { id: row.id } }" class="dropdown-item">Collect Shipper</router-link>

        <router-link v-else-if="(row.od_status == 8 || row.latest_status.status==1 || row.latest_status.status==2 || row.latest_status.status==6 || row.latest_status.status==7 || row.latest_status.status==8) && orderSt.includes(3)" 
        :to="{ name: 'delivar_or_return', params: { id: row.id } }" class="dropdown-item">Deliver/Return</router-link>

        
       

    </div>
</div>
</template>

<script>
export default {
    props: ["row", "column"],
    data() {
        return {
            orderSt: [],
        }
    },
    created() {
       // console.dir(this.column);
       this.getOrderStatuses();  
    },
    methods:{
        async getOrderStatuses() {
            let filterObj = {status:1};
            this.$root.addData(filterObj, "/api/user/orderstatus/paramonlyid").then(res => {
                this.orderSt = res.data.data;
               // console.dir(this.orderSt);

               // if(this.orderSt.includes(7)){
               //  console.log('ha ha');
               //  console.dir(this.orderSt);
               // }else{
               //  console.log('Nai');
               // }
            }).catch(err => {
                 //console.dir(err);
            })
        }

    }
};
</script>

<style scoped>
.dropdown-item {
    background-color: #ffffff;
    padding: 2px 12px !important;
}
</style>
