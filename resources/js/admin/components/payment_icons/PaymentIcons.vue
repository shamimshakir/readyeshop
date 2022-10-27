<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Payment Logos" btnRoute="add_payment_logo" btnName="Add Payment Logo"  :menu_name="routeName"/>
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="icon in icons" :key="icon.id">
                        <td>{{ icon.id }}</td>
                        <td>{{ icon.name }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=picon_image_url+icon.logo /></td>
                        <td class="text-center">
                            <StatusBadge :status="icon.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_payment_logo', params: { id: icon.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            loading: false,
            icons: [],
            picon_image_url: "",
        }
    },
    created() {
        this.getPaymentIcons();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getPaymentIcons() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/paymenticons');
            this.picon_image_url = data[0].url;
            this.icons = data[0].data;
            this.loading = false;
        },
    }
}
</script>

<style scoped>
.img-thumbnail {
    max-height: 50px;
}
</style>
