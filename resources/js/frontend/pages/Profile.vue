<template>
  <div  >
    <Header />
    <Breadcrumbs title="Profile" />
    <!-- personal deatail section start -->
    
    <section class="contact-page profile-page">
      <form class="theme-form" @submit.prevent="customerInputsSave">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <h3>Personal Detail</h3> 
                  <div class="form-row">
                    <div class="col-md-6">
                        <label for="firstname">Name</label>
                        <input 
                        type="text" 
                        class="form-control !isEmpty(errors) && !customerInputs.firstname
                ? 'form-control border-danger'
                : 'form-control' " 
                        id="firstname" 
                        v-model="customerInputs.firstname" 
                        placeholder="Name" 
                        name="firstname" />
                        <p class="text-danger" v-if="
                            errors.firstname.length > 0 && !customerInputs.firstname
                        " v-for="name in errors.firstname">
                            {{ firstname }}
                        </p>  
                        
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input 
                        type="email" 
                        class="form-control !isEmpty(errors) && !customerInputs.email
                ? 'form-control border-danger': 'form-control' " 
                        id="email" 
                        v-model="customerInputs.email" 
                        placeholder="Email" 
                        name="email" />
                        <p class="text-danger" v-if="
                            errors.email.length > 0 && !customerInputs.email
                        " v-for="email in errors.email">
                            {{ email }}
                        </p> 
                        
                    </div>

                    <div class="col-md-6">
                        <label for="phone">Mobile</label>
                        <input 
                        type="phone" 
                        class="form-control !isEmpty(errors) && !customerInputs.phone
                ? 'form-control border-danger': 'form-control' "
                        id="phone" 
                        v-model="customerInputs.phone" 
                        placeholder="Mobile" 
                        name="phone" />
                        <p class="text-danger" v-if="
                            errors.phone.length > 0 && !customerInputs.phone
                        " v-for="phone in errors.phone">
                            {{ phone }}
                       </p>                   
                    </div> 

                  </div>               
                </div>           
              </div>
           
            <div class="row">
              <div class="col-sm-12">
                <h3>Shipping Address</h3>
                  <div class="form-row">                
                    <div class="col-md-6">
                        <label>Address <span style="color:red;">*</span></label>
                        <input type="text" 
                        class="form-control !isEmpty(errors) && !customerInputs.address
                ? 'form-control border-danger': 'form-control' "
                        v-model="customerInputs.address">

                        <p class="text-danger" v-if="
                            errors.address.length > 0 && !customerInputs.address
                        " v-for="address in errors.address">
                            {{ address }}
                       </p>
                        
                    </div> 
                     <div class="col-md-6 select_input">
                        <label>Country </label>
                        <select 
                        class="form-control !isEmpty(errors) && !customerInputs.country
                ? 'form-control border-danger': 'form-control' "
                        v-model="customerInputs.country" 
                        @change="getCities($event)"
                        size="1"
                        >
                            <option disabled value="0">Select Country</option>
                            <option v-for="country in countries" :value="country.id" :key="country.id">
                                {{ country.name }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="
                            errors.country.length > 0 && !customerInputs.country
                        " v-for="country in errors.country">
                            {{ country }}
                       </p>
                        
                    </div>

                    <div class="col-md-6 select_input">
                        <label for="country">City </label>
                        <select 
                        class="form-control !isEmpty(errors) && !customerInputs.district
                ? 'form-control border-danger': 'form-control' " 
                        v-model="customerInputs.district" 
                        @change="getThanas($event)"
                        size="1"
                        >
                            <option disabled value="0">Select City</option>
                            <option v-for="city in cities" :value="city.id" :key="city.id">
                                {{ city.location }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="
                            errors.district.length > 0 && !customerInputs.district
                        " v-for="district in errors.district">
                            {{ district }}
                       </p>
                    </div>
                    <div class="col-md-6 select_input">
                        <label for="thana">Thana </label>
                        <select 
                        class="form-control !isEmpty(errors) && !customerInputs.thana
                ? 'form-control border-danger': 'form-control' "  
                        v-model="customerInputs.thana"
                        size="1"
                        >

                            <option disabled value="0">Select Thana</option>
                            <option v-for="thana in thanas" :value="thana.id" :key="thana.id">
                                {{ thana.name }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="
                            errors.thana.length > 0 && !customerInputs.thana
                        " v-for="thana in errors.thana">
                            {{ thana }}
                       </p>
                    </div>
                    <div class="col-md-12">
                      <button class="btn btn-sm btn-solid" type="submit">Save setting</button>
                    </div>
                  </div>
                
              </div>
            </div>
          </div>
      </form>
    </section>
 
    <!-- Section ends -->
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
    Breadcrumbs
  },
  data() {
    return {     
      countries: [],
      cities: [],
      thanas: [],
      errors: [],
      customerInputs: {},
    }
  },
  created() {
    this.getCustomer();
   
  },
  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
  },
  methods: {
    isEmpty(obj) {
        return Object.keys(obj).length === 0;
    },
    async getCustomer() {
        let dataObj = {};
        let data = await this.$root.getDetailsData(dataObj,`/api/customer/getcust`);
        this.customerInputs = data.data.data;
        
        Promise.all([
            this.getAllContries(),
            this.getAllCities(),
            this.getAllThanas(),
        ]).then((res) => {
            this.countries = res[0].data.data;
           // console.log(res[0]);
            this.cities = res[1].data.data;
            this.thanas = res[2].data.data;
            
        });
    },    
    async getAllContries() {
            let dataObj = {
                'id': 18
            };
          return await this.$root.getFrontData(dataObj,"/api/country_param");
        },
    async getAllCities() {
            let id = this.customerInputs.country;
            let dataObj = {
                'country': id
            };
          return await  this.$root.getFrontData(dataObj,`/api/district_param`);
        },
    async getAllThanas() {
            let id = this.customerInputs.city;
            let dataObj = {
                'district': id
            };
          return await  this.$root.getFrontData(dataObj,`/api/thana_param`);
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
        customerInputsSave() {                
            this.$root.getDetailsData(this.customerInputs, `/api/customer/custupdate`)
                .then(res => {
                    Vue.$toast.open({
                        message: res.data.message,
                        position: 'top-right',
                        type: 'success',
                        duration: 3000,
                        dismissible: false,
                    });
                   this.$router.push("/account/dashboard").catch(() => {});
                }).catch(error => {
                    console.dir(error);
                let res = JSON.parse(error.request.response);                                
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    Vue.$toast.open({
                        message: "Failed to Update",
                        position: 'top-right',
                        type: 'warning',
                        duration: 3000,
                        dismissible: false,                        
                    });
                }
            })
        },
  }
}
</script>
