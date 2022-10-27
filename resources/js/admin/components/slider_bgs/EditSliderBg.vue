<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Slider Background" btnRoute="slider_bgs" btnName="Slider Backgrounds" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="UpdateSlider($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Background Type<span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !slider.bg_type
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.bg_type">
                                <option value="">Select Type</option>
                                <option value="1">Slider</option>
                                <option value="2">Banner</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.bg_type.length > 0 && !slider.bg_type
                            " v-for="bg_type in errors.bg_type">
                                {{ bg_type }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !slider.active_status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="slider.active_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.active_status.length > 0 && !slider.active_status
                            " v-for="active_status in errors.active_status">
                                {{ active_status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Main Text </label>
                            <textarea rows="4" type="text" class="form-control" v-model="slider.main_text" placeholder="Main Text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Second Text </label>
                            <textarea rows="4" type="text" class="form-control" v-model="slider.second_text" placeholder="Second Text"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Image ( Width: 1920px, Height: 1080px ) <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="errors.image.length > 0 && !slider.image" v-for="image in errors.image">
                                {{ image }}
                            </p>
                            <img class="img-thumbnail" :src="slider_image_url + slider.image" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Additional Text </label>
                            <textarea rows="4" type="text" class="form-control" v-model="slider.additional_text" placeholder="Additional Text"></textarea>
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
        }
    },
    created() {
        this.getslider();
    },
    methods: {
        handleImage(files) {
            this.sliderImageInput = files[0];
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getslider() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(
                `/api/user/slider_backgrounds/${this.$route.params.id}`
            );
            this.slider_image_url = data[0].url;
            this.slider = data[0].data[0];
            this.loading = false;
        },
        UpdateSlider(event) {
            var form = new FormData();
            form.append("bg_type", this.slider.bg_type);
            form.append("additional_text", this.slider.additional_text);
            form.append("second_text", this.slider.second_text);
            form.append("main_text", this.slider.main_text);
            form.append("active_status", this.slider.active_status);
            form.append("image", this.sliderImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/slider_backgrounds/${this.$route.params.id}?_method=PUT`, form, {
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
                        name: "slider_bgs",
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
