<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Email Setups" btnRoute="add_email_setup" btnName="Add Email Setup" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Port</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>SMTPAuth</th>
                        <th>Host</th>
                        <th>SMTPSecure</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="emailSetup in emailSetups" :key="emailSetup.id">
                        <td>{{ emailSetup.id }}</td>
                        <td>{{ emailSetup.name }}</td>
                        <td>{{ emailSetup.port }}</td>
                        <td>{{ emailSetup.Username }}</td>
                        <td>{{ emailSetup.Password }}</td>
                        <td>{{ emailSetup.SMTPAuth }}</td>
                        <td>{{ emailSetup.Host }}</td>
                        <td>{{ emailSetup.SMTPSecure }}</td>
                        <td class="text-center">
                            <StatusBadge :status="emailSetup.status.id" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_email_setup', params: { id: emailSetup.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            emailSetups: [],
        }
    },
    created() {
        this.getEmailSetups();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getEmailSetups() {
            this.loading = true;
            this.emailSetups = await this.$root.getAllData('/api/user/emailsetups');
            this.loading = false;
        },
    }
}
</script>
