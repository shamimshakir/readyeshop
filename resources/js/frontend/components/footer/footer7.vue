<template>
  <div>
    <footer class="footer-light pet-layout-footer">
      <div class="white-layout">
        <div class="container">
          <section class="small-section">
            <div class="row footer-theme2">
              <div class="col">
                <div class="footer-link link-white">
                  <div class="footer-brand-logo">
                    <a href="#">
                      <img :src="companyimg + companyinfo.logo" class="img-fluid" alt />
                    </a>
                  </div>
                  <div class="social-white">
                    <ul>
                      <li v-for="(item, index) in socialitems">
                        <a v-bind:href="item.url">
                          <i v-bind:class="item.icon" aria-hidden="true"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                  <div class="footer-title footer-mobile-title">
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
      <div class="sub-footer black-subfooter">
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

<script>
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
  },
};
</script>
