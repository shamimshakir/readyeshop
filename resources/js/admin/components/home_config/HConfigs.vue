<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Homepage Config" btnRoute="add_home_config" btnName="Add Config" :menu_name="routeName" />
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
                    <tr v-for="hConfig in hConfigs" :key="hConfig.id">
                        <td>{{ hConfig.id }}</td>
                        <td>{{ hConfig.name }}</td>
                        <td class="text-center">
                            <StatusBadge :status="hConfig.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_home_config', params: { id: hConfig.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            hConfigs: [],
        }
    },
    created() {
        this.gethConfigs();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async gethConfigs() {
            this.loading = true;
            this.hConfigs = await this.$root.getAllData('/api/user/homeconfigs');
            this.loading = false;
        },
    }
}
</script>
