<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Customer" btnRoute="customers" btnName="Customers" />
        <div class="card-body">
            <!-- {{ errors }} -->
            <form @submit.prevent="addCustomer($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="firstname">First Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="customerInputs.firstname" placeholder="First Name" :class="checkError('firstname')
                                ? 'form-control border-danger'
                                : 'form-control' "  />
                            <p class="text-danger" v-if="checkError('firstname')" v-for="firstname in errors.firstname">
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
                            <input type="text" v-model="customerInputs.phone" placeholder="Phone Number" :class="checkError('phone')
                                ? 'form-control border-danger'
                                : 'form-control' " />
                            <p class="text-danger" v-if="checkError('phone')" v-for="phone in errors.phone">
                                {{ phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" v-model="customerInputs.email" name="email" placeholder="Email Address" :class="checkError('email')
                                ? 'form-control border-danger'
                                : 'form-control' " />
                            <p class="text-danger"  v-if="checkError('email')" v-for="email in errors.email">
                                {{ email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Country <span class="text-danger">*</span></label>
                            <select :class="checkError('country')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="customerInputs.country" @change="getCities($event)">
                                <option disabled value="">Select Country</option>
                                <option v-for="country in countries" :value="country.id" :key="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('country')" v-for="country in errors.country">
                                {{ country }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="city">City <span class="text-danger">*</span></label>
                            <select :class="checkError('city')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="customerInputs.city" @change="getThanas($event)">
                                <option disabled value="">Select City</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">
                                    {{ city.location }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('city')" v-for="city in errors.city">
                                {{ city }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="thana">Thana <span class="text-danger">*</span></label>
                            <select :class="checkError('thana')
                                ? 'form-control border-danger'
                                : 'form-control' "  v-model="customerInputs.thana">
                                <option disabled value="">Select Thana</option>
                                <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                    {{ thana.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('thana')" v-for="thana in errors.thana">
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
                            <input type="text" v-model="customerInputs.address" placeholder="Address" :class="checkError('address')
                                ? 'form-control border-danger'
                                : 'form-control' " />
                            <p class="text-danger" v-if="checkError('address')" v-for="address in errors.address">
                                {{ address }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="postal_code">Password <span class="text-danger">*</span></label>
                            <input type="password" :class="checkError('cl_pin')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="customerInputs.cl_pin" placeholder="Password" />
                            <p class="text-danger"  v-if="checkError('cl_pin')"  v-for="cl_pin in errors.cl_pin">
                                {{ cl_pin }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Customer</button>
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
            customerInputs: {
                country: "",
                city: "",
                thana: "",
                user_stat: ""
            },
            countries: [],
            cities: [],
            thanas: [],
            errors: {},
        };
    },
    created() {
        this.getAllContries();
    },
    mounted() {},
    methods: {
        checkError(field){
            if(!this.isEmpty(this.errors)){
                if(field in this.errors){
                    return true
                }
            }
            return false;
        },
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

        addCustomer(event) {
            this.$root.addData(this.customerInputs, '/api/user/customers').then(response => {
                
                this.$fire({
                        title: response.data.message,
                        type: "success",
                        timer: 2000
                });
                event.target.reset();
                this.$router.push({
                    name: "customers"
                });
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                    console.dir(this.errors)
                }
            })
        },

    },
};
</script>
