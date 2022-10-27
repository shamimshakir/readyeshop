<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Vendor" btnRoute="vendors" btnName="Vendors" />
        <div class="card-body">
            <form @submit.prevent="addVendor($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Vendor Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !vendor.vendor_name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.vendor_name" placeholder="Vendor Name" />
                            <p class="text-danger" v-if="
                                errors.vendor_name.length > 0 && !vendor.vendor_name
                            " v-for="vendor_name in errors.vendor_name">
                                {{ vendor_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>User Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !vendor.vendor_user
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.vendor_user" placeholder="User Name" />
                            <p class="text-danger" v-if="
                                errors.vendor_user.length > 0 && !vendor.vendor_user
                            " v-for="vendor_user in errors.vendor_user">
                                {{ vendor_user }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !vendor.vendor_pass
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.vendor_pass" placeholder="Password" />
                            <p class="text-danger" v-if="
                                errors.vendor_pass.length > 0 && !vendor.vendor_pass
                            " v-for="vendor_pass in errors.vendor_pass">
                                {{ vendor_pass }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Company Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !vendor.company_name
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.company_name" placeholder="Company Name" />
                            <p class="text-danger" v-if="
                                errors.company_name.length > 0 && !vendor.company_name
                            " v-for="company_name in errors.company_name">
                                {{ company_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" v-model="vendor.phone" placeholder="Phone" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" v-model="vendor.email" placeholder="Email" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Country </label>
                            <select  :class="
                                !isEmpty(errors) && !vendor.country
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.country" @change="getCities($event)">
                                <option disabled value="">Select Country</option>
                                <option v-for="country in countries" :value="country.id" :key="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.country.length > 0 && !vendor.country " v-for="country in errors.country">
                                {{ country }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">City </label>
                            <select :class="
                                !isEmpty(errors) && !vendor.city
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.city" @change="getThanas($event)">
                                <option disabled value="">Select City</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">
                                    {{ city.location }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.city.length > 0 && !vendor.city " v-for="city in errors.city">
                                {{ city }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="thana">Thana </label>
                            <select :class="
                                !isEmpty(errors) && !vendor.thana
                                ? 'form-control border-danger'
                                : 'form-control'
                                " v-model="vendor.thana">
                                <option disabled value="">Select Thana</option>
                                <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                    {{ thana.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="errors.thana.length > 0 && !vendor.thana " v-for="thana in errors.thana">
                                {{ thana }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Postal Code </label>
                            <input type="text" class="form-control" v-model="vendor.postal_code" placeholder="Postal Code" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Reward Point Parcent </label>
                            <input type="text" class="form-control" v-model="vendor.reward_point_percent" placeholder="Reward Point Parcent" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Reward Point Parcent Customer </label>
                            <input type="text" class="form-control" v-model="vendor.reward_point_percent_customer" placeholder="Reward Point Parcent Customer " />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Pickup Location ID </label>
                            <input type="text" class="form-control" v-model="vendor.pick_loc_id" placeholder="Pickup Location ID" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !vendor.status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="errors.status.length > 0 && !vendor.status " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea type="text" :class="
                                !isEmpty(errors) && !vendor.address
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="vendor.address" placeholder="Address"></textarea>
                            <p class="text-danger" v-if="
                                errors.address.length > 0 && !vendor.address
                            " v-for="address in errors.address">
                                {{ address }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Vendor</button>
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
            vendor: {
                status: "",
                country: "",
                city: "",
                thana: "",
            },
            countries: [],
            cities: [],
            thanas: [],
            errors: [],
        }
    },
    created() {
        this.getAllContries();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getAllContries() {
            this.countries = await this.$root.getAllData(
                "/api/user/countries"
            );
        },

        getCities(event) {
            let id = event.target.value;
            this.$root.getAllData(
                `/api/user/districts/showByCountrys/${id}`
            ).then(res => {
                this.cities = res;
            });
        },

        getThanas(event) {
            let id = event.target.value;
            this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
            ).then(res => {
                this.thanas = res;
            })
        },

        addVendor(event) {
            this.$root.addData(this.vendor, '/api/user/vendors').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "vendors",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add Vendor",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
