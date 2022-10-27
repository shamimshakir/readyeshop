<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Customer" btnRoute="customers" btnName="Customers" />
        <div class="card-body">
            <vue-loaders-line-scale-pulse-out v-if="loading" color="#3f51b5" />
            <form @submit.prevent="updateCustomer" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="firstname">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" v-model="customerInputs.firstname" placeholder="First Name" :class="
                                    !isEmpty(errors) && !customerInputs.firstname
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " />
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.firstname.length > 0" v-for="firstname in errors.firstname">
                                {{ firstname }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" v-model="customerInputs.lastname" placeholder="Last Name" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" v-model="customerInputs.phone" placeholder="Phone Number" :class="
                                (!isEmpty(errors) && !customerInputs.phone) || (!isEmpty(errors) && errors.phone.length > 0)
                                ? 'form-control border-danger'
                                : 'form-control'
                            " />
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.phone.length > 0" v-for="phone in errors.phone">
                                {{ phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" v-model="customerInputs.email" name="email" placeholder="Email Address" :class="
                                (!isEmpty(errors) && !customerInputs.email) || (!isEmpty(errors) && errors.email.length > 0)
                                ? 'form-control border-danger'
                                : 'form-control'
                            " />
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.email.length > 0" v-for="email in errors.email">
                                {{ email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select :class="
                                    !isEmpty(errors) && !customerInputs.country
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="customerInputs.country" @change="getCities($event)">
                                <option disabled value="0">Select Country</option>
                                <option v-for="country in countries" :value="country.id" :key="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.country.length > 0" v-for="country in errors.country">
                                {{ country }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">City <span class="text-danger">*</span></label>
                            <select :class="
                                    !isEmpty(errors) && !customerInputs.city
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="customerInputs.city" @change="getThanas($event)">
                                <option disabled value="0">Select City</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">
                                    {{ city.location }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.city.length > 0" v-for="city in errors.city">
                                {{ city }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="thana">Thana <span class="text-danger">*</span></label>
                            <select :class="
                                    !isEmpty(errors) && !customerInputs.thana
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="customerInputs.thana">
                                <option disabled value="0">Select Thana</option>
                                <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                    {{ thana.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.thana.length > 0" v-for="thana in errors.thana">
                                {{ thana }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" v-model="customerInputs.street" placeholder="Street" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="postal_code">Postal Code</label>
                            <input type="text" class="form-control" v-model="customerInputs.postal_code" placeholder="Postal Code" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Status</label>
                            <select class="form-control" v-model="customerInputs.user_stat">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inctive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <input type="text" v-model="customerInputs.address" placeholder="Address" :class="
                                    !isEmpty(errors) && !customerInputs.address
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " />
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.address.length > 0" v-for="address in errors.address">
                                {{ address }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="postal_code">Password <span class="text-danger">*</span></label>
                            <input type="password" :class="
                                !isEmpty(errors) && !customerInputs.address
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="customerInputs.cl_pin" placeholder="Password" />
                            <p class="text-danger" v-if="!isEmpty(errors) && errors.cl_pin.length > 0" v-for="cl_pin in errors.cl_pin">
                                {{ cl_pin }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Customer</button>
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
            customerInputs: {},
            countries: [],
            cities: [],
            thanas: [],
            errors: {},
            loading: false,
        };
    },
    created() {
        this.getCustomer();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getCustomer() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/customers/${this.$route.params.id}`
            );
            this.customerInputs = data[0];
            Promise.all([
                this.getAllContries(),
                this.getCustomerCity(),
                this.getCustomerThana(),
            ]).then((res) => {
                this.countries = res[0];
                this.cities = res[1];
                this.thanas = res[2];
                this.loading = false;
            });
        },
        async getAllContries() {
            return await this.$root.getAllData(
                "/api/user/countries"
            );
        },
        async getCustomerCity() {
            let id = this.customerInputs.country;
            return await this.$root.getAllData(
                `/api/user/districts/showByCountrys/${id}`
            );
        },
        async getCustomerThana() {
            let id = this.customerInputs.city;
            return await this.$root.getAllData(
                `/api/user/thanas/showByDistricts/${id}`
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
        updateCustomer() {
            this.$root.updateData(this.customerInputs, `/api/user/customers/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "customers",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
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
        },
    },
};
</script>
