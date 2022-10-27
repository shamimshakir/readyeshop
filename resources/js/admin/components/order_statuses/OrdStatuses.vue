<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Order Status" btnRoute="add_ord_status" btnName="Add Status" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-line-scale-pulse-out v-if="loading" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Order Status </th>
                        <th>Serial</th>
                        <th>Icon</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="od_status in or_statuses" :key="od_status.id">
                        <td>{{ od_status.id }}</td>
                        <td>{{ od_status.ord_status }}</td>
                        <td>{{ od_status.sl }}</td>
                        <td>{{ od_status.icon }}</td>
                        <td class="text-center">
                            <StatusBadge :status="od_status.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_ord_status', params: { id: od_status.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            or_statuses: [],
        }
    },
    created() {
        this.getOdStatuses();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getOdStatuses() {
            this.loading = true;
            this.or_statuses = await this.$root.getAllData('/api/user/orderStatus');
            this.loading = false;
        },
    }
}
</script>
