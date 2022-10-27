<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Banner" btnRoute="banners" btnName="Banners" />
        <div class="card-body">
            <form @submit.prevent="AddBanner($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !banner.title
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="banner.title" placeholder="Title" />
                            <p class="text-danger" v-if="
                                errors.title.length > 0 && !banner.title
                            " v-for="title in errors.title">
                                {{ title }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !banner.comp_name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="banner.comp_name" placeholder="Company Name" />
                            <p class="text-danger" v-if="
                                errors.comp_name.length > 0 && !banner.comp_name
                            " v-for="comp_name in errors.comp_name">
                                {{ comp_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Company URL <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !banner.comp_url
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="banner.comp_url" placeholder="Company URL" />
                            <p class="text-danger" v-if="
                                errors.comp_url.length > 0 && !banner.comp_url
                            " v-for="comp_url in errors.comp_url">
                                {{ comp_url }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <datepicker format="yyyy-MM-dd" :input-class="
                                !isEmpty(errors) && !banner.end_date
                                ? 'form-control border-danger'
                                : 'form-control'
                            " placeholder="Select Date" v-model="banner.start_date"></datepicker>
                            <p class="text-danger" v-if="
                                errors.start_date.length > 0 && !banner.start_date
                            " v-for="start_date in errors.start_date">
                                {{ start_date }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>end_date <span class="text-danger">*</span></label>
                            <datepicker format="yyyy-MM-dd" :input-class="
                                !isEmpty(errors) && !banner.end_date
                                ? 'form-control border-danger'
                                : 'form-control'
                            " placeholder="Select Date" v-model="banner.end_date"></datepicker>
                            <p class="text-danger" v-if="
                                errors.end_date.length > 0 && !banner.end_date
                            " v-for="end_date in errors.end_date">
                                {{ end_date }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !banner.active_status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="banner.active_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.active_status.length > 0 && !banner.active_status
                            " v-for="active_status in errors.active_status">
                                {{ active_status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Banner Image <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="errors.image.length > 0 && !banner.image" v-for="image in errors.image">
                                {{ image }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Banner</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import UploadImages from "vue-upload-drop-images";
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        CardHeader,
        UploadImages,
        Datepicker
    },
    data() {
        return {
            banner: {
                active_status: "",
                start_date: "",
                end_date: "",
            },
            bannerImageInput: null,
            errors: [],
        }
    },
    created() {},
    methods: {
        handleImage(files) {
            this.bannerImageInput = files[0];
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        AddBanner(event) {
            var form = new FormData();
            form.append("title", this.banner.title);
            form.append("comp_url", this.banner.comp_url);
            form.append("comp_name", this.banner.comp_name);
            form.append("start_date", this.formatDate(this.banner.start_date));
            form.append("end_date",  this.formatDate(this.banner.end_date));
            form.append("pd_code", this.banner.pd_code);
            form.append("active_status", this.banner.active_status);
            form.append("image", this.bannerImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/banners`, form, {
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
                        name: "banners",
                    });
                    event.target.reset();
                })
                .catch((error) => {
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to Add Banner",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>
