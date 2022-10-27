<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="sliders" btnRoute="add_slider" btnName="Add Slider" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Title</th>
                        <th>Main Text</th>
                        <th>Alternative Text</th>
                        <th>URL</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="slider in sliders" :key="slider.id">
                        <td>{{ slider.id }}</td>
                        <td>{{ slider.title_text }}</td>
                        <td>{{ slider.main_text }}</td>
                        <td>{{ slider.alt_text }}</td>
                        <td>{{ slider.url }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=slider_image_url+slider.bg_img /></td>
                        <td class="text-center">
                            <StatusBadge :status="slider.act_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_slider', params: { id: slider.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            sliders: [],
            slider_image_url: "",
        }
    },
    created() {
        this.getSliders();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getSliders() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/slider_details');
            this.slider_image_url = data[0].url;
            this.sliders = data[0].data;
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