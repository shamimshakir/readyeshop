<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Meta Tags" btnRoute="add_meta_tag" btnName="Add Meta Tag" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Meta Page</th>
                        <th>Meta Name</th>
                        <th>Meta Content</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="metatag in metatags" :key="metatag.id">
                        <td>{{ metatag.id }}</td>
                        <td>{{ metatag.meta_page }}</td>
                        <td>{{ metatag.meta_name }}</td>
                        <td>{{ metatag.meta_content }}</td>
                        <td class="text-center">
                            <StatusBadge :status="metatag.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_meta_tag', params: { id: metatag.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            metatags: [],
        }
    },
    created() {
        this.getMetatags();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getMetatags() {
            this.loading = true;
            this.metatags = await this.$root.getAllData('/api/user/metatags');
            this.loading = false;
        },
    }
}
</script>
