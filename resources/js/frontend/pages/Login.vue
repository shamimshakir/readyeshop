<template>
  <div>
    <Header />
    <Breadcrumbs title="Login" />
    <section class="login-page section-b-space">
      <vue-loaders-ball-clip-rotate-multiple v-if="pageLoading" scale="1.5" color="#000" />
      
      <div class="container"  v-bind:class="{ lessOpacity: pageLoading }">
        
        <div class="row">
          <div class="col-lg-6">
            <h3>{{ logintitle }}</h3>
            <div class="theme-card">
              <form class="theme-form" @submit.prevent="checkLogin">
                <div class="form-group">
                  <label for="email">Email</label>

                  <input
                    type="email"
                    class="
                      form-control
                      !isEmpty(errors)
                      &&
                      !logInput.email
                      ?
                      'form-control
                      border-danger'
                      :
                      'form-control'
                    "
                    id="email"
                    v-model="logInput.email"
                    placeholder="Email"
                    name="email"
                  />

                  <p
                    class="text-danger"
                    v-if="errors.email.length > 0 && !logInput.email"
                    v-for="email in errors.email"
                  >
                    {{ email }}
                  </p>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input
                    type="password"
                    class="
                      form-control
                      !isEmpty(errors)
                      &&
                      !logInput.password
                      ?
                      'form-control
                      border-danger'
                      :
                      'form-control'
                    "
                    id="password"
                    v-model="logInput.password"
                    placeholder="Enter your password"
                    name="password"
                  />
                  <p
                    class="text-danger"
                    v-if="errors.password.length > 0 && !logInput.password"
                    v-for="password in errors.password"
                  >
                    {{ password }}
                  </p>
                </div>
                <button type="submit" class="btn btn-solid">Login</button>
                <!-- Social Media -->
                <div class="social mt-3">
                  <div class="form-group btn-showcase d-flex">
                    <button type="button"
                      @click="AuthProvider('facebook')"
                      class="btn social-btn btn-fb d-inline-block"
                      v-if="facebook_status==true">
                      <i class="fa fa-facebook"></i>
                    </button>
                    <button type="button" @click="AuthProvider('google')" class="btn social-btn btn-twitter d-inline-block" v-if="google_status==true">
                      <i class="fa fa-google"></i>
                    </button>
                    <button type="button"
                      @click="AuthProvider('twitter')"
                      class="btn social-btn btn-google d-inline-block" v-if="twitter_status==true"
                    >
                      <i class="fa fa-twitter"></i>
                    </button>
                    <button type="button"
                     @click="AuthProvider('github')"
                      class="btn social-btn btn-github d-inline-block" v-if="github_status==true"
                    >
                      <i class="fa fa-github"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6 right-login">
            <h3>{{ registertitle }}</h3>
            <div class="theme-card authentication-right">
              <h6 class="title-font">Create A Account</h6>

              <p>
                Sign up for a free account at our store. Registration is quick
                and easy. It allows you to be able to order from our shop. To
                start shopping click register.
              </p>

              <router-link
                :to="{ path: '/account/register' }"
                class="btn btn-solid"
              >
                Create an Account
              </router-link>

              
            </div>
          </div>
        </div>
      </div>
    </section>
    <Footer />
  </div>

</template>

<script>
import Breadcrumbs from "../components/widgets/breadcrumbs";
import VueSocialauth from 'vue-social-auth';
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
      logintitle: "Login",
      pageLoading: false,
      registertitle: "New Customer",
      githubid: '',
      facebookid: '',
      googleid: '',
      twitterid: '',
      github_status:false,
      facebook_status:false,
      google_status:false,
      twitter_status:false,
      logInput: {
        email: "",
        password: "",
      },
      errors: [],
      meta: {},
      auth:[]
    };
  },
  created() { 
    this.checkSessionToken();
    this.getMeta();
  
    this.getAuthParam().then(res => {

        let socData = res.data.data;
        socData.forEach(authdata => {
          if(authdata.name=='google'){
              this.googleid=authdata.app_id;
              this.google_status=true;
          }else if(authdata.name=='facebook'){
              this.facebookid=authdata.app_id;
              this.facebook_status=true;
          }else if(authdata.name=='github'){
              this.githubid=authdata.app_id;
              this.github_status=true;
          }else if(authdata.name=='twitter'){
              this.twitterid=authdata.app_id;
              this.twitter_status=true;
          }            
        })
        this.useSocial(this.githubid, this.facebookid, this.googleid, this.twitterid);
    })
  },

  methods: {
    useSocial(a, b, c, d){
      Vue.use(VueSocialauth, {
        providers: {
          github: {
            clientId: a,
            redirectUri: '/auth/github/callback' // Your client app URL
          },
          facebook: {
            clientId: b,
            redirectUri: '/auth/facebook/callback' // Your client app URL
          },
          google: {
            clientId: c,
            redirectUri: '/auth/google/callback' // Your client app URL
          },
          twitter: {
            clientId: d,
            redirectUri: '/auth/twitter/callback' // Your client app URL
          }
       }
      });
    },
    checkSessionToken() {
      let sessionData = JSON.parse(sessionStorage.getItem("loginInfo"));
      if (sessionData) {
        this.$router.push("/account/dashboard").catch(() => {});
      } else {
        this.$router.push("/account/login").catch(() => {});
      }
    },
    async getMeta() {
            let dataObj = {
                'meta_page': 'login',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
    },
    async getAuthParam() {
            let dataObj = {
                'status': '1',
            };
            return await this.$root.getFrontData(dataObj, `/api/thirdpartyauths/param`);
    },
    checkLogin() {
      this.pageLoading = true;
      var qs = require("qs");
      var config = {
        method: "post",
        url: `${this.$store.state.hostBase}/api/customer/login`,
        data: qs.stringify(this.logInput),
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
          this.$store.commit("UPDATE_ISLOGIN", true);
          this.$router.push("/account/dashboard").catch(() => {});
          this.pageLoading = false;
          //location.reload();
        })
        .catch((error) => {
          let res = JSON.parse(error.request.response);
          if (res.status == "error") {
            this.errors = JSON.parse(error.request.response).validation_errors;
          } else {
            Vue.$toast.open({
              message: "Failed to Registration",
              position: "top-right",
              type: "warning",
              duration: 3000,
              dismissible: false,
            });
          }
          this.pageLoading = false;
        });
    },
    AuthProvider(provider) {            
        var self = this        
        this.$auth.authenticate(provider).then(response =>{
          //console.dir(response);       
          self.SocialLogin(provider,response)

          }).catch(err => {
             // console.log({err:err})
          })
    },            
    SocialLogin(provider,response){
          this.pageLoading = true;
         this.$http.post('/sociallogin/'+provider,response).then(response => {
         // console.log(response.data);
          if(response.data!=null){
           let dataObj = {
                'email': response.data.email,
                'phone': null,
                'country': 0,
                'city': 0,
                'thana': 0,
                'password': null,
                'name': response.data.name,
                'address': null,
                'provider': provider,
                'provider_id': response.data.id,
                'avatar': response.data.avatar,
                'access_token': response.data.token,
              };
             // console.log(dataObj);
            this.registration_social(dataObj);

          }
                     
        }).catch(err => {
           // console.log({err:err});
        })
    },
   async registration_social(data) {
          await this.$root.getFrontData(data, `/api/customer/register_social`)
              .then(res => {
                  //console.dir(res);
                  this.checkLogin_social(res.data.data[0].provider_id,res.data.data[0].cl_pin);
              }).catch(error => {
                ///console.dir(error);
              })
    },

   checkLogin_social(provider_id,password) {
      var qs = require("qs");
      var config = {
        method: "post",
        url: `${this.$store.state.hostBase}/api/customer/login_social`,
        data: qs.stringify({'provider_id':provider_id,'password':password}),
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
          this.pageLoading = false;
          this.$store.commit("UPDATE_ISLOGIN", true);
          this.$router.push("/account/dashboard").catch(() => {});
        })
        .catch( );
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
};
</script>
