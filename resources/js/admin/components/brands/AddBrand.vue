<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Brand" btnRoute="brands" btnName="Brands" />
        <div class="card-body">
            <form @submit.prevent="addBrand($event)">
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
                            <label>Other Brand Name </label>
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
                <button type="submit" class="btn btn-primary">Create Brand</button>
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
            brand: {
                status: "",
            },
            errors: [],
        }
    },
    created() {
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
  
        addBrand(event) {
            this.$root.addData(this.brand, '/api/user/brands').then(response => {
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
                console.dir(error)
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add Brand",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
