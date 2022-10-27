<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit About us" btnRoute="about_us" btnName="About us" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateAboutUs($event)" enctype="multipart/form-data" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Short Description <span class="text-danger">*</span></label>
                            <tinymce id="d1" :other_options="tinyOptions"  v-model="aboutUs.short_description"></tinymce>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <tinymce id="d2" :other_options="tinyOptions"  v-model="aboutUs.au_description"></tinymce>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Image ( Width: 1370px, Height: 400px ) <span class="text-danger">*</span></label>
                        <div class="imageUploadBox">
                            <UploadImages :max="2" @changed="handleImages" />
                            <div class="previousImg">
                                <img :src="image_url + previous_au_image" />
                            </div>
                        </div>
                    </div>
                    <br />
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";

import UploadImages from "vue-upload-drop-images";

export default {
    components: {
        CardHeader,
        UploadImages,
    },
    data() {
        return {
            aboutUs: {},
            errors: [],
            previous_au_image: "",
            ab_image: null,
            image_url: null,
            tinyOptions: {
                'height': 200
            }
        };
    },
    created() {
        this.getAbout();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        handleImages(files) {
            this.ab_image = files[0];
           // console.log(files);
        },

        async getAbout() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(`/api/user/about_us/1`);
            this.aboutUs = data[0].data[0];
            this.previous_au_image = `${this.aboutUs.au_image}`;
            this.image_url = data[0].url;            
            this.loading = false;
        },
        updateAboutUs(event) {
            let formData = new FormData();
            formData.append("au_description", this.aboutUs.au_description);
            formData.append("short_description", this.aboutUs.short_description);
            formData.append("au_image", this.ab_image);
            //console.dir(files);
            this.axios
                .post(
                    `${this.$store.state.hostBase}/api/user/about_us/1?_method=PUT`,
                    formData, {
                        headers: {
                            Authorization: `Bearer ${this.$store.state.token}`,
                            "Content-Type": "multipart/form-data",
                        },
                    }
                )
                .then((res) => {
                    this.$alert(res.data.message);
                    event.target.reset();
                    this.$router.push({
                        name: "about_us"
                    });
                })
                .catch((err) => {
                    // let res = JSON.parse(err.request.response);
                    console.dir(err);
                    // alert("failed to update");
                });
        },
    },
};
</script>

<style scoped>
/* .previousImg img {
    height: 100px;
} */
</style>
