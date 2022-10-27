<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Vendors"
                btnRoute="add_vendor"
                btnName="Add Vendor"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Reg. Date</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="vendor in vendors" :key="vendor.id">
                        <td>{{ vendor.id }}</td>
                        <td>{{ vendor.vendor_name }}</td>
                        <td>{{ vendor.company_name }}</td>
                        <td>{{ vendor.phone }}</td>
                        <td>{{ vendor.email }}</td>
                        <td>{{ vendor.user_regdate }}</td>
                        <td class="text-center">
                            <StatusBadge :status="vendor.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_vendor', params: { id: vendor.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                vendors: [],
            }
        },
        created() {
            this.getVendors();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getVendors() {
                this.loading = true;
                this.vendors = await this.$root.getAllData('/api/user/vendors');
                this.loading = false;
            },
        }
    }
</script>
