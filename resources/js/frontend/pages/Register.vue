<template>
<div>
    <Header />
    <Breadcrumbs title="Register" />
    <section class="register-page section-b-space">
        <vue-loaders-ball-clip-rotate-multiple v-if="pageLoading" scale="1.5" color="#000" />
        <div class="container" v-bind:class="{ lessOpacity: pageLoading }">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{title}}</h3>
                    <div class="theme-card">
                        <form class="theme-form" @submit.prevent="registration">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control !isEmpty(errors) && !regInput.name
                            ? 'form-control border-danger'
                            : 'form-control' " id="name" v-model="regInput.name" placeholder="Name" name="name" />
                                    <p class="text-danger" v-if="
                                        errors.name.length > 0 && !regInput.name
                                    " v-for="name in errors.name">
                                        {{ name }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control !isEmpty(errors) && !regInput.email
                            ? 'form-control border-danger': 'form-control' " id="email" v-model="regInput.email" placeholder="Email" name="email" />
                                    <p class="text-danger" v-if="
                                        errors.email.length > 0 && !regInput.email
                                    " v-for="email in errors.email">
                                        {{ email }}
                                    </p>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="phone">Mobile</label>
                                    <input type="phone" class="form-control !isEmpty(errors) && !regInput.phone
                                        ? 'form-control border-danger': 'form-control' " id="phone" v-model="regInput.phone" placeholder="Mobile" name="phone" />

                                    <p class="text-danger" v-if="
                                        errors.phone.length > 0 && !regInput.phone
                                    " v-for="phone in errors.phone">
                                        {{ phone }}
                                    </p>
                                </div>

                                <div class="col-md-6 select_input">
                                    <label>Country </label>
                                    <select class="form-control !isEmpty(errors) && !regInput.country
                            ? 'form-control border-danger': 'form-control' " v-model="regInput.country" @change="getCities($event)">
                                        <option disabled value="0">Select Country</option>
                                        <option v-for="country in countries" :value="country.id" :key="country.id">
                                            {{ country.name }}
                                        </option>
                                    </select>
                                    <p class="text-danger" v-if="
                                        errors.country.length > 0 && !regInput.country
                                    " v-for="country in errors.country">
                                        {{ country }}
                                    </p>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-6 select_input">
                                    <label for="country">City </label>
                                    <select class="form-control !isEmpty(errors) && !regInput.city
                            ? 'form-control border-danger': 'form-control' " v-model="regInput.city" @change="getThanas($event)">
                                        <option disabled value="0">Select City</option>
                                        <option v-for="city in cities" :value="city.id" :key="city.id">
                                            {{ city.location }}
                                        </option>
                                    </select>
                                    <p class="text-danger" v-if="
                                        errors.city.length > 0 && !regInput.city
                                    " v-for="city in errors.city">
                                        {{ city }}
                                    </p>
                                </div>
                                <div class="col-md-6 select_input">
                                    <label for="thana">Thana </label>
                                    <select class="form-control !isEmpty(errors) && !regInput.thana
                            ? 'form-control border-danger': 'form-control' " v-model="regInput.thana">

                                        <option disabled value="0">Select Thana</option>
                                        <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                            {{ thana.name }}
                                        </option>
                                    </select>
                                    <p class="text-danger" v-if="
                                        errors.thana.length > 0 && !regInput.thana
                                    " v-for="thana in errors.thana">
                                        {{ thana }}
                                    </p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Address <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control !isEmpty(errors) && !regInput.address
                            ? 'form-control border-danger': 'form-control' " v-model="regInput.address" placeholder="Address">

                                    <p class="text-danger" v-if="
                                        errors.address.length > 0 && !regInput.address
                                    " v-for="address in errors.address">
                                        {{ address }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control !isEmpty(errors) && !regInput.password
                            ? 'form-control border-danger': 'form-control' " id="password" v-model="regInput.password" placeholder="Enter your password" name="password" />

                                    <p class="text-danger" v-if="
                                        errors.password.length > 0 && !regInput.password
                                    " v-for="password in errors.password">
                                        {{ password }}
                                    </p>
                                </div>

                                <button type="submit" class="btn btn-solid mt-2">create account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</div>
</template>

<script>
import Breadcrumbs from '../components/widgets/breadcrumbs'
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
export default {
    components: {
        Header,
		Footer,
        Breadcrumbs,
    },
    data() {
        return {
            pageLoading: false,
            title: 'create account',
            regInput: {
                name: "",
                email: "",
                phone: "",
                country: "0",
                city: "0",
                thana: "0",
                address: "",
                password: "",
            },
            errors: [],
            countries: [],
            cities: [],
            thanas: [],
            meta: {},
        }
    },
    created() {
        this.getAllContries();
        this.getMeta();
    },
    methods: {

        async getAllContries() {
            let dataObj = {
                'id': 18
            };
            await this.$root.getFrontData(dataObj,
                "/api/country_param").then(res => {
                this.countries = res.data.data;
            });
        },
        async getMeta() {
            let dataObj = {
                'meta_page': 'register',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
        },
        getCities(event) {
            let id = event.target.value;
            let dataObj = {
                'country': id
            };
            this.$root.getFrontData(dataObj,
                `/api/district_param`
            ).then(res => {
                this.cities = res.data.data;
            });
        },

        getThanas(event) {
            let id = event.target.value;
            let dataObj = {
                'district': id
            };
            this.$root.getFrontData(dataObj,
                `/api/thana_param`
            ).then(res => {
                this.thanas = res.data.data;
            })
        },
        registration() {
            this.pageLoading = true;
            this.$root.getFrontData(this.regInput, `/api/customer/register`)
                .then(res => {
                    Vue.$toast.open({
                        message: res.data.message,
                        position: 'top-right',
                        type: 'success',
                        duration: 3000,
                        dismissible: false,
                    });
                    this.checkLogin(this.regInput.email, this.regInput.password);
                    this.pageLoading = false;
                }).catch(error => {
                    console.dir(error);
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        Vue.$toast.open({
                            message: "Failed to Registration",
                            position: 'top-right',
                            type: 'warning',
                            duration: 3000,
                            dismissible: false,
                        });
                    }
                    this.pageLoading = false;
                })
        },

        checkLogin(email, password) {
            var qs = require("qs");
            var config = {
                method: "post",
                url: `${this.$store.state.hostBase}/api/customer/login`,
                data: qs.stringify({
                    'email': email,
                    'password': password
                }),
            };
            this.axios(config)
                .then((response) => {
                    let sessionObj = {
                        email: response.data.users.email,
                        phone: response.data.users.phone,
                        full_name: response.data.users.firstname,
                        token: response.data.token,
                    };
                    sessionStorage.setItem("loginInfo", JSON.stringify(sessionObj));
                    this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", response.data.token);
                    location.reload();
                })
                .catch();
        },
    },
    metaInfo() {
        return {            
            title:  this.meta.meta_name, 
            meta: [
                { name: 'description', content:  this.meta.meta_content},
                { name: 'keywords', content:  this.meta.meta_type},
                { property: 'og:title', content: this.meta.meta_content},
                { property: 'og:site_name', content: this.meta.meta_name},
                {property: 'og:type', content: 'website'},    
                {name: 'robots', content: 'index,follow'} 
            ]
        }
    },
}
</script>

<style>
.register-page .theme-card .theme-form select {
    border-color: #dddddd;
    font-size: 12px;
    padding: 17px 25px;
    margin-bottom: 15px;
    height: inherit;
}
</style>
