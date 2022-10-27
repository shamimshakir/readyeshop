<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Brand Logos" btnRoute="add_brand_logo" btnName="Add Brand Logo" :menu_name="routeName"/>
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Link</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brandLogo in brandLogos" :key="brandLogo.id">
                        <td>{{ brandLogo.id }}</td>
                        <td>{{ brandLogo.name }}</td>
                        <td>{{ brandLogo.link }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=brandLogo_image_url+brandLogo.logo /></td>
                        <td class="text-center">
                            <StatusBadge :status="brandLogo.act_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_brand_logo', params: { id: brandLogo.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            brandLogos: [],
            brandLogo_image_url: "",
        }
    },
    created() {
        this.getbrandLogos();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getbrandLogos() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/sponsorads');
            this.brandLogo_image_url = data[0].url;
            this.brandLogos = data[0].data;
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