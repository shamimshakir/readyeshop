<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Units"
                btnRoute="add_unit"
                btnName="Add Unit"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="unit in units" :key="unit.id">
                        <td>{{ unit.id }}</td>
                        <td>{{ unit.unit_display }}</td>
                        <td class="text-center">
                            <StatusBadge :status="unit.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_unit', params: { id: unit.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                units: [],
            }
        },
        created() {
            this.getunits();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getunits() {
                this.loading = true;
                this.units = await this.$root.getAllData('/api/user/units');
                this.loading = false;
            },
        }
    }
</script>
