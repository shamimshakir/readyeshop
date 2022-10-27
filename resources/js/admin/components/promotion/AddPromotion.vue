<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Promotion" btnRoute="promotions" btnName="Promotions" />
        <div class="card-body">
            <form @submit.prevent="AddPromotion($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name </label>
                            <input type="text" :class="
                            !isEmpty(errors) && !promotion.name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="promotion.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !promotion.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Offer </label>
                            <input type="text" :class="
                            !isEmpty(errors) && !promotion.promotionpercent
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="promotion.promotionpercent" placeholder="Offer" />
                            <p class="text-danger" v-if="
                                errors.promotionpercent.length > 0 && !promotion.promotionpercent
                            " v-for="promotionpercent in errors.promotionpercent">
                                {{ promotionpercent }}
                            </p>
                        </div>
                    </div>



                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Url </label>
                            <input type="text" :class="
                            !isEmpty(errors) && !promotion.url
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="promotion.url" placeholder="Url" />
                            <p class="text-danger" v-if="
                                errors.url.length > 0 && !promotion.url
                            " v-for="url in errors.url">
                                {{ url }}
                            </p>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !promotion.status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="promotion.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !promotion.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Promotion Image ( Width: 672px, Height: 310px ) <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="errors.image.length > 0 && !promotion.image" v-for="image in errors.image">
                                {{ image }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create promotion</button>
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
            promotion: {
                status: "",
                image: "",
            },
            promotionImageInput: null,
            errors: [],
        }
    },
    created() {},
    methods: {
        handleImage(files) {
            this.promotionImageInput = files[0];
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
        AddPromotion(event) {
            var form = new FormData();
            form.append("name", this.promotion.name);
            form.append("promotionpercent", this.promotion.promotionpercent);
            form.append("url", this.promotion.url);
            form.append("status", this.promotion.status);
            form.append("image", this.promotionImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/promotions`, form, {
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
                        name: "promotions",
                    });
                    event.target.reset();
                })
                .catch((error) => {
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to Add promotion",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>
