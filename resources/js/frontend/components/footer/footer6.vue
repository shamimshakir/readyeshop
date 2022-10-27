<template>
  <div>
    <footer
      class="bg-img-gym"
      v-bind:style="{ 'background-image': `url(https://vue.pixelstrap.com/multikart/_nuxt/img/bg.b333b8f.jpg)` }"
    >
      <!-- <img :src='"@/assets/images/gym/bg.jpg"' alt class="bg-img blur-up lazyload" /> -->
      <div class="dark-layout">
        <div class="container">
          <section class="section-b-space border-b">
            <div class="row footer-theme2">
              <div class="col-lg-3">
                <div class="footer-title footer-mobile-title">
                  <h4>about</h4>
                </div>
                <div class="footer-contant">
                  <div class="footer-logo">
                    <img :src="companyimg + companyinfo.logo" class="img-fluid" alt />
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et.Lorem ipsum dolor sit amet, consectetur adipiscing</p>
                </div>
              </div>
              <div class="col-lg-6 subscribe-wrapper">
                <div class="subscribe-block">
                  <h2>newsletter</h2>
                  <form @submit.prevent="suscrives">
                    <div class="form-group">
                      <input
                        type="text"
                        class="form-control"
                        id="exampleFormControlInput3"
                        placeholder="Enter your email"
                        v-model="suscrived.email"
                      />
                      <button type="submit" class="btn btn-solid btn-gradient">subscribe</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="footer-title">
                  <h4>store information</h4>
                </div>
                <div class="footer-contant">
                  <ul class="contact-details">
                    <li>{{ companyinfo.comp_address }}</li>
                    <li>Call Us: {{ companyinfo.contact_phone }}</li>
                    <li>
                      Email Us:
                      <a href="#">{{ companyinfo.contact_email }}</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="dark-layout">
        <div class="container">
          <section class="small-section">
            <div class="row footer-theme2">
              <div class="col p-set">
                <div class="footer-link">
                  <div class="footer-title">
                    <h4>my account</h4>
                  </div>
                  <div class="footer-contant">
                    <ul>
                      <li>
                        <router-link :to="{ path: '/account/wishlist' }">WishList</router-link>
                      </li>
                      <li>
                        <router-link :to="{ path: '/account/compare' }">Compare</router-link>
                      </li>
                      <li v-if="isLogin">
                        <router-link :to="{ path: '/account/dashboard' }">Dashboard</router-link>
                      </li>
                      <li>
                        <a v-if="isLogin" v-on:click="logout">Logout</a>
                        <router-link v-else :to="{ path: '/account/login' }">Login</router-link>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="footer-link-b">
                  <div class="footer-title">
                    <h4>why we choose</h4>
                  </div>
                  <div class="footer-contant">
                    <ul>
                      <li v-for="(item, index) in pcitems">
                        <router-link
                          :to="{ name: 'others', params: { pagename: item.page_name } }"
                        >{{ item.page_title }}</router-link>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <div class="sub-footer darker-subfooter">
        <div class="container">
          <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-12">
              <div class="footer-end">
                <p>
                  <i class="fa fa-copyright" aria-hidden="true"></i>
                  2020-{{ currentDate() }} {{ companyinfo.company_name }}-All Rights Reserved
                </p>
              </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-12">
              <div class="payment-card-bottom">
                <ul>
                  <li v-for="(item, index) in paymentitems">
                    <a href="#">
                      <img :src="imageSrc + item.logo" alt />
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>
<script type="text/javascript">
export default {
  data() {
    return {
      pcitems: [],
      socialitems: [],
      paymentitems: [],
      imageSrc: "",

      suscrived: {
        email: "",
      },

      errors: [],
    };
  },
  created() {
    this.getPageContentsDetail();
    this.getSocialDetail();
    this.getpaymentDetail();
  },
  computed: {
    companyinfo() {
      return this.$store.state.companyInfo;
    },
    companyimg() {
      return this.$store.getters.companyImg;
    },
    isLogin() {
      return this.$store.state.isLogin;
    },
  },
  methods: {
    currentDate() {
      const current = new Date();
      let year = `${current.getFullYear()}`;
      return year;
    },
    async getPageContentsDetail() {
      let dataObj = {
        active_status: 1
      };
      let pagecontentData = await this.$root.getFrontData(dataObj, `/api/pagecontent_param`);
      this.pcitems = pagecontentData.data.data;
    },
    async getSocialDetail() {
      let dataObj = {
        active_status: 1
      };
      let socialData = await this.$root.getFrontData(dataObj, `/api/social_param`);
      this.socialitems = socialData.data.data;
    },
    async getpaymentDetail() {
      let dataObj = {
        status: 1
      };
      let paymentData = await this.$root.getFrontData(dataObj, `/api/paymenticon_param`);
      this.paymentitems = paymentData.data.data;
      this.imageSrc = paymentData.data.url;
    },
    logout() {
      sessionStorage.removeItem("loginInfo");
      this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
      this.$store.commit("UPDATE_ISLOGIN", false);
      this.isAuthenticated = false;
      this.$router.push("/account/login").catch(() => { });
      //   location.reload();
    },
    suscrives() {
      this.$root.getFrontData(this.suscrived, `/api/subscribes`)
        .then(res => {
          Vue.$toast.open({
            message: res.data.message,
            position: 'top-right',
            type: 'success',
            duration: 3000,
            dismissible: false,
          });
        }).catch(error => {
          console.dir(error);
          let res = JSON.parse(error.request.response);
          if (res.status == "error") {
            this.errors = JSON.parse(error.request.response).validation_errors;
            Vue.$toast.open({
              message: this.errors.email,
              position: 'top-right',
              type: 'warning',
              duration: 3000,
              dismissible: false,
            });

          } else {
            Vue.$toast.open({
              message: "Failed to Subscribe",
              position: 'top-right',
              type: 'warning',
              duration: 3000,
              dismissible: false,
            });
          }
        })
    },
  },
};
</script>
