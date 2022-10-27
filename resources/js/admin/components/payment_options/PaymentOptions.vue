<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Payment Options"
                btnRoute="add_payment_options"
                btnName="Add New"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Pharm</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="paymentOption in paymentOptions" :key="paymentOption.id">
                        <td>{{ paymentOption.id }}</td>
                        <td>{{ paymentOption.name }}</td>
                        <td>{{ paymentOption.pharm }}</td>
                        <td class="text-center">
                            <StatusBadge :status="paymentOption.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_payment_options', params: { id: paymentOption.id }}" class="btn btn-info btn-sm">Edit</router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CardHeader from "../basics/CardHeader";
    import StatusBadge from "../basics/StatusBadge";
    export default {
        components: {
            StatusBadge,
            CardHeader,
        },
        data() {
            return {
                loading:false,
                paymentOptions: [],
            }
        },
        created() {
            this.getPaymentOptions();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getPaymentOptions() {
                this.loading = true;
                this.paymentOptions = await this.$root.getAllData('/api/user/paymentoptions');
                this.loading = false;
            },
        }
    }
</script>
