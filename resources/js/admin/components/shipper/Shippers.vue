<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Shippers"
                btnRoute="add_shipper"
                btnName="Add Shipper"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Con. Person</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="shipper in shippers" :key="shipper.id">
                        <td>{{ shipper.id }}</td>
                        <td>{{ shipper.sp_name }}</td>
                        <td>{{ shipper.sp_mobile }}</td>
                        <td>{{ shipper.sp_email }}</td>
                        <td>{{ shipper.sp_sddress }}</td>
                        <td>{{ shipper.sp_contact_person }}</td>
                        <td class="text-center">
                            <StatusBadge :status="shipper.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_shipper', params: { id: shipper.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                shippers: [],
            }
        },
        created() {
            this.getShippers();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getShippers() {
                this.loading = true;
                this.shippers = await this.$root.getAllData('/api/user/shippers');
                this.loading = false;
            },
        }
    }
</script>
