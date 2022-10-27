<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Email Templates"
                btnRoute="add_email_template"
                btnName="Add Template"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>ShortCode</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="template in emailTemplates" :key="template.id">
                        <td>{{ template.id }}</td>
                        <td>{{ template.short_code }}</td>
                        <td>{{ template.title }}</td>
                        <td>{{ template.subject }}</td>
                        <td>{{ template.body }}</td>
                        <td class="text-center">
                            <StatusBadge :status="template.status.id"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_email_template', params: { id: template.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                emailTemplates: [],
            }
        },
        created() {
            this.getEmailTemplates();
        },
        methods: {
            async getEmailTemplates() {
                this.loading = true;
                this.emailTemplates = await this.$root.getAllData('/api/user/emailtemplates');
                this.loading = false;
            },
        }
    }
</script>
