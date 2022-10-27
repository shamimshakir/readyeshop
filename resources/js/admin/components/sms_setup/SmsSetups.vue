<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="SMS Setups"
                btnRoute="add_sms_setup"
                btnName="Add Setup"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>SMS URL</th>
                        <th>Submit Param</th>
                        <th>Type</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="setup in smssetups" :key="setup.id">
                        <td>{{ setup.id }}</td>
                        <td>{{ setup.name }}</td>
                        <td>{{ setup.sms_url }}</td>
                        <td>{{ setup.submit_param }}</td>
                        <td>{{ setup.type }}</td>
                        <td class="text-center">
                            <StatusBadge :status="setup.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_sms_setup', params: { id: setup.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                smssetups: [],
            }
        },
        created() {
            this.getSmsSetups();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getSmsSetups() {
                this.loading = true;
                this.smssetups = await this.$root.getAllData('/api/user/smssetups');
                this.loading = false;
            },
        }
    }
</script>
