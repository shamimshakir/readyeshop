<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Payment Logo" btnRoute="payment_logos" btnName="Payment Logos" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="editPaymentIcon($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !pIcon.name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="pIcon.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !pIcon.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !pIcon.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="pIcon.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !pIcon.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Image * (Note: Image must be transparent)</label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="errors.image.length > 0 && !pIcon.image" v-for="image in errors.image">
                                {{ image }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Previous Image</label>
                            <img class="img-thumbnail" :src="payment_image_url + pIcon.logo" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Payment Logo</button>
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
            pIcon: {},
            paymentImageInput: null,
            errors: [],
            payment_image_url: null,
            loading: false,
        }
    },
    created() {
        this.getPaymentIcon();
    },
    methods: {
        handleImage(files) {
            this.paymentImageInput = files[0];
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getPaymentIcon() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(
                `/api/user/paymenticons/${this.$route.params.id}`
            );
            this.payment_image_url = data[0].url;
            this.pIcon = data[0].data[0];
            this.loading = false;
        },
        editPaymentIcon(event) {
            var form = new FormData();
            form.append("name", this.pIcon.name);
            form.append("status", this.pIcon.status);
            form.append("logo", this.paymentImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/paymenticons/${this.$route.params.id}?_method=PUT`, form, {
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
                        name: "payment_logos",
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
                            title: "Failed to Update",
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
