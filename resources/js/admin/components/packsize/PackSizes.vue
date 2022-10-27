<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Pack sizes"
                btnRoute="add_pack_size"
                btnName="Add Pack Size"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Pack Weight</th>
                        <th>Pack Height</th>
                        <th>Pack Width</th>
                        <th>Pack Length</th>
                        <th>Cubic Size</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="packsize in packsizes" :key="packsize.id">
                        <td>{{ packsize.id }}</td>
                        <td>{{ packsize.packweight }}</td>
                        <td>{{ packsize.packheight }}</td>
                        <td>{{ packsize.packwidth }}</td>
                        <td>{{ packsize.packlength }}</td>
                        <td>{{ packsize.cubicsize }}</td>
                        <td class="text-center">
                            <StatusBadge :status="packsize.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_pack_size', params: { id: packsize.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                packsizes: [],
            }
        },
        created() {
            this.getpacksizes();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getpacksizes() {
                this.loading = true;
                this.packsizes = await this.$root.getAllData('/api/user/packsizes');
                this.loading = false;
            },
        }
    }
</script>
