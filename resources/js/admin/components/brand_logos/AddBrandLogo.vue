<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Brand Logo" btnRoute="brand_logos" btnName="Brand Logos" />
        <div class="card-body">
            <form @submit.prevent="AddBrandLogo($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                checkError('name')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="brandLogo.name" placeholder="Name" />
                            <p class="text-danger" v-if="checkError('name')" v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Company URL <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                checkError('link')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="brandLogo.link" placeholder="Company URL" />
                            <p class="text-danger" v-if="checkError('link') " v-for="link in errors.link">
                                {{ link }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>brandLogo (Image size must be 180*60 pixel for better look.) <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="checkError('logo')" v-for="logo in errors.logo">
                                {{ logo }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                checkError('act_status')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="brandLogo.act_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="checkError('act_status')" v-for="act_status in errors.act_status">
                                {{ act_status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Brand Logo</button>
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
            brandLogo: {
                act_status: "",
                name: "",
                link: "",
                logo:"",
            },
            brandLogoImageInput: null,
            errors: [],
        }
    },
    created() {},
    methods: {
        handleImage(files) {
            this.brandLogoImageInput = files[0];
        },
        checkError(field) {
            if (!this.isEmpty(this.errors)) {
                if (field in this.errors) {
                    return true
                }
            }
            return false;
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        AddBrandLogo(event) {
            var form = new FormData();
            form.append("name", this.brandLogo.name);
            form.append("link", this.brandLogo.link);
            form.append("act_status", this.brandLogo.act_status);
            form.append("logo", this.brandLogoImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/sponsorads`, form, {
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
                        name: "brand_logos",
                    });
                    event.target.reset();
                })
                .catch((error) => {
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to Add brand Logo",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>
