<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Brand Logo" btnRoute="brand_logos" btnName="Brand Logos" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="UpdateBanner($event)" v-bind:class="{ lessOpacity: loading }">
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
                            <p class="text-danger" v-if="checkError('link')" v-for="link in errors.link">
                                {{ link }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>brandLogo Image (Image size must be 180*60 pixel for better look.) <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <img class="img-thumbnail" :src=brandLogo_image_url+brandLogo.logo />
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
                <button type="submit" class="btn btn-primary">Update Brand Logo</button>
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
            errors: [],
            brandLogo_image_url: null,
            brandLogo: {
                act_status: "",
            },
            brandLogoImageInput: null,
            errors: [],
            loading: false,
        }
    },
    created() {
        this.getBrandLogo();
    },
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
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },        
        async getBrandLogo() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(
                `/api/user/sponsorads/${this.$route.params.id}`
            );                
            this.brandLogo_image_url = data[0].url;
            this.brandLogo = data[0].data[0];
            this.loading = false;            
        },
        UpdateBanner(event) {
            var form = new FormData();
            form.append("name", this.brandLogo.name);
            form.append("link", this.brandLogo.link);
            form.append("act_status", this.brandLogo.act_status);
            form.append("logo", this.brandLogoImageInput);
            this.axios
                .post(`${this.$store.state.hostBase}/api/user/sponsorads/${this.$route.params.id}?_method=PUT`, form, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.dir(res)
                    this.$fire({
                        title: res.data.message,
                        type: "success",
                        timer: 2000
                    });
                    this.$router.push({
                        name: "brand_logos",
                    });
                    event.target.reset();
                })
                .catch((err) => {
                    console.dir(err)
                    let res = JSON.parse(err.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(err.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to update",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>

