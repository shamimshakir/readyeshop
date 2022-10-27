<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Messanger Chat" btnRoute="add_fb_messanger" btnName="Add Messanger"  :menu_name="routeName"/>
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>API Name</th>
                        <th>API Code</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="fb_messanger in fb_messangers" :key="fb_messanger.id">
                        <td>{{ fb_messanger.id }}</td>
                        <td>{{ fb_messanger.name }}</td>
                        <td>{{ fb_messanger.command }}</td>
                        <td class="text-center">
                            <StatusBadge :status="fb_messanger.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_fb_messanger', params: { id: fb_messanger.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            fb_messangers: [],
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
            this.fb_messangers = await this.$root.getAllData('/api/user/fbmassengers');
            this.loading = false;
        },
    }
}
</script>
