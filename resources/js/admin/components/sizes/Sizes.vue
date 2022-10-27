<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Sizes"
                btnRoute="add_size"
                btnName="Add Size"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Remarks</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="size in sizes" :key="size.id">
                        <td>{{ size.id }}</td>
                        <td>{{ size.size_display }}</td>
                        <td>{{ size.size_type }}</td>
                        <td>{{ size.size_remarks }}</td>
                        <td class="text-center">
                            <StatusBadge :status="size.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_size', params: { id: size.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                sizes: [],
            }
        },
        created() {
            this.getSizes();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getSizes() {
                this.loading = true;
                this.sizes = await this.$root.getAllData('/api/user/sizes');
                this.loading = false;
            },
        }
    }
</script>
