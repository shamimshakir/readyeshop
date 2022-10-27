<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Slider" btnRoute="sliders" btnName="Sliders" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="UpdateSlider($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Slider Type<span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !slider.slider_id
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.slider_id">
                                <option value="">Select Type</option>
                                <option v-for="slider in sliderTypes" :value="slider.id">{{ slider.slider_name }}</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.slider_id.length > 0 && !slider.slider_id
                            " v-for="slider_id in errors.slider_id">
                                {{ slider_id }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !slider.title_text
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.title_text" placeholder="Title" />
                            <p class="text-danger" v-if="
                                errors.title_text.length > 0 && !slider.title_text
                            " v-for="title_text in errors.title_text">
                                {{ title_text }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !slider.act_status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.act_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.act_status.length > 0 && !slider.act_status
                            " v-for="act_status in errors.act_status">
                                {{ act_status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Main Text <span class="text-danger">*</span></label>
                            <textarea rows="5" type="text" :class="
                            !isEmpty(errors) && !slider.main_text
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.main_text" placeholder="Main Text"></textarea>
                            <p class="text-danger" v-if="
                                errors.main_text.length > 0 && !slider.main_text
                            " v-for="main_text in errors.main_text">
                                {{ main_text }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Image( Width: 1903px, Height: 559px ) <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="errors.bg_img.length > 0 && !slider.bg_img" v-for="bg_img in errors.bg_img">
                                {{ bg_img }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Current Image</label>
                            <img class="img-thumbnail" :src="slider_image_url + slider.bg_img" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Slider</button>
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
            slider: {},
            sliderImageInput: null,
            errors: [],
            slider_image_url: null,
            loading: false,
            sliderTypes: [],
        }
    },
    created() {
        this.getslider();
        this.getsliderTypes();
    },
    methods: {
        handleImage(files) {
            this.sliderImageInput = files[0];
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getsliderTypes() {
            this.sliderTypes = await this.$root.getAllData("/api/user/sliders");
        },
        async getslider() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(
                `/api/user/slider_details/${this.$route.params.id}`
            );
            this.slider_image_url = data[0].url;
            this.slider = data[0].data[0];
            this.loading = false;
        },
        UpdateSlider(event) {
            var form = new FormData();
            form.append("slider_id", this.slider.slider_id);
            form.append("url", this.slider.url);
            form.append("main_text", this.slider.main_text);
            form.append("title_text", this.slider.title_text);
            form.append("act_status", this.slider.act_status);
            form.append("bg_img", this.sliderImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/slider_details/${this.$route.params.id}?_method=PUT`, form, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.$fire({
                        title: response.data.message,
                        type: "success",
                        timer: 2000
                    });
                    this.$router.push({
                        name: "sliders",
                    });
                    event.target.reset();
                })
                .catch((error) => {
                    console.dir(error)
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to Add slider",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>

<style scoped>

</style>
