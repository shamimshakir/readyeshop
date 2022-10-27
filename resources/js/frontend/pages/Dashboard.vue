<template>
  <div v-if="isLogin">
    <Header />
    <Breadcrumbs title="Dashboard" />
    <section class="section-b-space">
      <div class="container">
        <div class="row">
          <b-card no-body v-bind:class="'dashboardtab'">
            <b-tabs pills card vertical>
              <b-tab title="Account Info" active>
                <b-card-text>
                  <div class="dashboard-right">
                    <div class="dashboard">
                      <div class="page-title">
                        <h2>My Dashboard</h2>
                      </div>
                      <div class="welcome-msg">
                        <p>Hello, {{customer.firstname}} !</p>
                        <p>
                          From your My Account Dashboard you have the ability to
                          view a snapshot of your recent account activity and
                          update your account information. Select a link below
                          to view or edit information.
                        </p>
                      </div>
                      <div class="box-account box-info">
                        <div class="box-head">
                          <h2>Account Information</h2>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="box">
                              <div class="box-title">
                                <h3>Contact Information</h3>
                                <router-link :to="{ path: '/account/profile' }">
                                  Edit
                                </router-link>
                              </div>
                              <div class="box-content">
                                <h6>{{customer.firstname}}</h6>
                                <h6>{{customer.email}}</h6>
                                <h6>
                                  <a href="#">Change Password</a>
                                </h6>
                              </div>
                            </div>
                          </div>
                          
                        </div>
                        <div>
                          <div class="box">
                            <div class="box-title">
                              <h3>Address Book</h3>
                              <router-link :to="{ path: '/account/profile' }">
                                  Manage Addresses
                              </router-link>
                              
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <h6>Default Billing Address</h6>
                                <address>
                                  {{customer.address}}, <br />
                                  {{custThana}},
                                  {{custCountry}}
                                  <br /><br />
                                  <router-link :to="{ path: '/account/profile' }">Edit Address</router-link>
                                </address>
                              </div>
                              <div class="col-sm-6">
                                <h6>Default Shipping Address</h6>
                                <address>                                 
                                  {{customer.address}}, <br />
                                  {{custThana}},
                                  {{custCity}}, 
                                  {{custCountry}}
                                  <br /><br />
                                  <router-link :to="{ path: '/account/profile' }">Edit Address</router-link>
                                </address>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </b-card-text>
              </b-tab>
              <b-tab title="Address Book">
                <b-card-text>
                  <div class="dashboard-right">
                    <div class="dashboard">
                      <div class="page-title">
                        <h2>Address Book</h2>
                      </div>
                      <div class="welcome-msg">
                        <p>Hello, {{customer.firstname}} !</p>
                        <p>
                          From your Address book you have the ability to change
                          or edit your shipping and billing address.
                        </p>
                      </div>
                      <div class="box-account box-info">
                        <div class="box-head">
                          <h2>Address Information</h2>
                        </div>
                        <div>
                          <div class="box">
                            <div class="box-title">
                              <h3>Address Book</h3>
                              <router-link :to="{ path: '/account/profile' }">Manage Addresses</router-link>
                              
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                <h6>Default Billing Address</h6>
                                <address> 
                                  {{customer.address}}, <br />
                                  {{custThana}},
                                  {{custCity}}, 
                                  {{custCountry}}
                                  <br /><br />
                                  <router-link :to="{ path: '/account/profile' }">Edit Address</router-link>
                                </address>
                              </div>
                              <div class="col-sm-6">
                                <h6>Default Shipping Address</h6>
                                <address>                                  
                                  {{customer.address}}, <br />
                                  {{custThana}}, 
                                  {{custCity}},  
                                  {{custCountry}}
                                  <br /><br />
                                  <router-link :to="{ path: '/account/profile' }">Edit Address</router-link>
                                </address>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </b-card-text>
              </b-tab>
              <b-tab title="My Orders">
                <b-card-text>
                  <div class="dashboard-right">
                    <div class="dashboard">
                      <div class="page-title">
                        <h2>My orders</h2>
                      </div>
                      <div class="welcome-msg">
                        <p>Hello, {{customer.firstname}} !</p>
                        <p>
                          From your Orders you have the ability to view your all
                          orders and status of order.
                        </p>
                      </div>
                      <div class="box-account box-info">
                        <div class="box-head">
                          <h2>Order Information</h2>
                        </div>
                        
                        <div>
                          <div class="box">
                            <div class="box-title mb-3">
                              <h3>orders list</h3>                             
                            </div>
                            <div class="row">

                              <div class="col-sm-6 mb-2" v-for="(order, index) in customer.orders" :key="index">

                                <router-link :to="{ name: 'ordertrack', params: { orderno: order.od_no, orderid: order.id }}" >
                                <h4>Order no: {{order.od_no}}</h4>  
                                </router-link>
                                
                                
                              </div>
                              
                            </div>
                          </div>
                        </div>

                       

                      </div>
                    </div>
                  </div>
                </b-card-text>
              </b-tab>              
              <b-tab title="Change Password">
                <b-card-text>
                  <div class="dashboard-right">
                    <div class="dashboard">
                      <div class="page-title">
                        <h2>Change password</h2>
                      </div>
                      <div class="welcome-msg">
                        <p>Hello, {{customer.firstname}} !</p>                        
                      </div>
                      <div class="box-account box-info">
                        <div class="box-head">
                          <h2>Account Information</h2>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="box">
                              <div class="box-title">
                                <h3>Contact Information</h3>
                                <a href="#">Edit</a>
                              </div>
                              <div class="box-content">
                                <h6>{{customer.firstname}}</h6>
                                <h6>{{customer.email}}</h6>
                                <h6>
                                <router-link :to="{ path: '/account/profile' }">Change Password</router-link>
                                  
                                </h6>
                              </div>
                            </div>
                          </div>                          
                        </div>
                      </div>
                    </div>
                  </div>
                </b-card-text>
              </b-tab>
              <b-tab title="Log out" v-on:click="logout">
                <b-card-text>
                  <div class="dashboard-right">
                    <div class="dashboard">
                      <div class="page-title">

                        <h2 v-on:click="logout">Log Out</h2>
                      </div>
                                            
                    </div>
                  </div>
                </b-card-text>
              </b-tab>
            </b-tabs>
          </b-card>
        </div>
      </div>
    </section>
    <Footer />
  </div>
</template>

<script>
import Breadcrumbs from "../components/widgets/breadcrumbs";
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
      isAuthenticated: false,
      customer: {},
      custThana: null,
      custCity: null,
      custCountry: null,
      meta: {},
    };
  },
  created() {
    this.getCustomerDetail().then(res => {      
      this.customer = res.data.data;
      console.dir(this.customer);
      this.custThana = this.customer.thanas.name;
      this.custCity = this.customer.districts.location;
      this.custCountry = this.customer.countries.name;
      console.log('country: '+this.custCountry );
    }).catch(err => {
     // console.dir(err)
    });
    this.getMeta();
  },
  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
  },
  methods: {
    async getCustomerDetail() {
      let dataObj = {};
      return await this.$root.getDetailsData(dataObj,`/api/customer/getalldata`);
    },
    async getMeta() {
        let dataObj = {
            'meta_page': 'dashboard',
            'status': '1',
        };
        let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
        this.meta = metaData.data.data[0];
    },
    logout() {
      sessionStorage.removeItem("loginInfo");
      this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
      this.$store.commit("UPDATE_ISLOGIN", false);
      this.isAuthenticated = false;
      this.$router.push("/account/login").catch(() => {});
      //   location.reload();
    },
  },
  metaInfo() {
      return {
          title: this.meta.meta_name + this.customer.firstname,
          meta: [
              { name: 'description', content: this.meta.meta_content },
              { name: 'keywords', content:  this.meta.meta_type},
              { property: 'og:title', content: this.meta.meta_content },
              { property: 'og:site_name', content: this.meta.meta_name + this.customer.firstname },
              { property: 'og:type', content: 'website' },
              { name: 'robots', content: 'index,follow' }
          ]
      }
  },
};
</script>
