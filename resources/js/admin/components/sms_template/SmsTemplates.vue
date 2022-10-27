<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="SMS Templates"
                btnRoute="add_sms_template"
                btnName="Add Template"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Command</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="template in templates" :key="template.id">
                        <td>{{ template.id }}</td>
                        <td>{{ template.command }}</td>
                        <td>{{ template.description }}</td>
                        <td>{{ template.type == 1 ? "System" : "User" }}</td>
                        <td class="text-center">
                            <StatusBadge :status="template.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_sms_template', params: { id: template.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                templates: [],
            }
        },
        created() {
            this.getSmsTemplates();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getSmsTemplates() {
                this.loading = true;
                this.templates = await this.$root.getAllData('/api/user/smstemplates');
                this.loading = false;
            },
        }
    }
</script>
