<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Brand" btnRoute="brands" btnName="Brands" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateBrand($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Brand Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                    !isEmpty(errors) && !brand.brand_display
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="brand.brand_display" placeholder="Brand Name" />
                            <p class="text-danger" v-if="
                                errors.brand_display.length > 0 && !brand.brand_display
                            " v-for="brand_display in errors.brand_display">
                                {{ brand_display }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Other Brand Name</label>
                            <input type="text" class="form-control" v-model="brand.other_band_name" placeholder="Other Brand Name" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !brand.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="brand.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !brand.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
export default {
    components: {
        CardHeader,
    },
    data() {
        return {
            errors: [],
            loading: false,
            brand: {},
        }
    },
    created() {
        this.getBrand();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getBrand() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/brands/${this.$route.params.id}`
            );
            this.brand = data[0];
            this.loading = false;
        },

        updateBrand(event) {
            this.$root.updateData(this.brand, `/api/user/brands/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "brands",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res)
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to update",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        }
    }
}
</script>
