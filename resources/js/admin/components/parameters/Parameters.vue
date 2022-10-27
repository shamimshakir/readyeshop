<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Parameters"
                btnRoute="add_parameter"
                btnName="Add Parameter"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Parameter Name</th>
                        <th>Parameter Value</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="parameter in parameters" :key="parameter.id">
                        <td>{{ parameter.id }}</td>
                        <td>{{ parameter.parameter_name }}</td>
                        <td>{{ parameter.parameter_value }}</td>
                        <td class="text-center">
                            <StatusBadge :status="parameter.parameter_status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_parameter', params: { id: parameter.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                parameters: [],
            }
        },
        created() {
            this.getparameters();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getparameters() {
                this.loading = true;
                this.parameters = await this.$root.getAllData('/api/user/parameters');
                this.loading = false;
            },
        }
    }
</script>
