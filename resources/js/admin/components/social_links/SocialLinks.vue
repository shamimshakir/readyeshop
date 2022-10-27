<template>
<div class="col-lg-12">
    <!-- <router-view /> -->
    <div class="card m-b-30 mt-5">
        <CardHeader title="Social Links" btnRoute="add_social" btnName="Add Social Link" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-line-scale-pulse-out v-if="loading" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Social Name</th>
                        <th>URL</th>
                        <th class="text-center">Icon</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="link in sLinks" :key="link.id">
                        <td>{{ link.id }}</td>
                        <td>{{ link.social_name }}</td>
                        <td>{{ link.url }} </td>
                        <td class="text-center"><i :class="link.icon"></i></td>
                        <td class="text-center">
                            <StatusBadge :status="link.active_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_social', params: { id: link.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            sLinks: [],
        }
    },
    created() {
        this.getSocialLinks();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getSocialLinks() {
            this.loading = true;
            this.sLinks = await this.$root.getAllData('/api/user/social_link');
            this.loading = false;
        },
    }
}
</script>
