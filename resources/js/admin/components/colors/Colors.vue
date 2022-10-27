<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Colors" btnRoute="add_color" btnName="Add Color" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-line-scale-pulse-out v-if="loading" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Color Name</th>
                        <th>Other Language</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="color in colors" :key="color.id">
                        <td>{{ color.id }}</td>
                        <td>{{ color.color_name }}</td>
                        <td>{{ color.other_language }}</td>
                        <td class="text-center">
                            <StatusBadge :status="color.color_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_color', params: { id: color.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            colors: [],
        }
    },
    created() {
        this.getCustomers();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getCustomers() {
            this.loading = true;
            this.colors = await this.$root.getAllData('/api/user/colors');
            this.loading = false;
        },
    }
}
</script>
