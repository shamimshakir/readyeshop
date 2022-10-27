<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Sponsor Banners" btnRoute="add_banner" btnName="Add Banner" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Title</th>
                        <th>Company Name</th>
                        <th>Company URL</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="banner in banners" :key="banner.id">
                        <td>{{ banner.id }}</td>
                        <td>{{ banner.title }}</td>
                        <td>{{ banner.comp_name }}</td>
                        <td>{{ banner.comp_url }}</td>
                        <td>{{ new Date(banner.start_date).toLocaleDateString() }}</td>
                        <td>{{ new Date(banner.end_date).toLocaleDateString() }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=banner_image_url+banner.image /></td>
                        <td class="text-center">
                            <StatusBadge :status="banner.active_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_banner', params: { id: banner.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            banners: [],
            banner_image_url: "",
        }
    },
    created() {
        this.getBanners();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getBanners() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/banners');
            this.banner_image_url = data[0].url;
            this.banners = data[0].data;
            this.loading = false;
        },
    }
}
</script>
<style scoped>
.img-thumbnail{
    max-height: 50px;
}
</style>