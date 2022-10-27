<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-header d-flex justify-content-between align-items-center font-16 mt-0">
            <strong class="text-primary">About Us</strong>
            <span>
                <button class="btn btn-warning btn-sm" @click="changeShowModal(true)">?</button>
                <router-link :to="{name: 'edit_about_us', params: { id: aboutUs.id }}" class="btn btn-primary btn-sm">Edit About us</router-link>
            </span>
            <help-modal :menu_name="routeName" />
        </div>
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div v-bind:class="{ lessOpacity: loading }">
                <h5>Description</h5>
                <div class="about_us_show_box border p-3">
                    <div class="description" v-html="aboutUs.au_description"></div>
                </div>
                <h5>Short Description</h5>
                <div class="about_us_show_box border p-3">
                    <div class="description" v-html="aboutUs.short_description"></div>
                </div>
                <h5>Image</h5>
                <img style="max-height: 250px;" :src="image_url + aboutUsImg" class="img-thumbnail" />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import StatusBadge from "../basics/StatusBadge";
import HelpModal from '../HelpModal'
export default {
    components: {
        StatusBadge,
        HelpModal,
        CardHeader,
    },
    data() {
        return {
            loading: false,
            aboutUs: {},
            aboutUsImg: "",
            image_url: null,
        }
    },
    created() {
        this.getAboutUs();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        changeShowModal(value) {
            this.$store.commit("UPDATE_HELP_MODAL_SHOW", value);
        },
        async getAboutUs() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/about_us/1');
            
            this.aboutUs = data[0].data[0];
            this.aboutUsImg = `${this.aboutUs.au_image}`;
            this.image_url = data[0].url;
            this.loading = false;
        },
    }
}
</script>
