<template>
  <div class="top-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="header-contact">
            <ul>
              <li>Welcome to {{ companyinfo.company_name }}</li>
              <li>
                <i class="fa fa-phone" aria-hidden="true"></i>Call Us:
                {{ companyinfo.contact_phone }}
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6 text-right">
          <ul class="header-dropdown">
            <li class="mobile-wishlist">
              <router-link :to="{ path: '/account/wishlist' }">
                <i class="fa fa-heart" aria-hidden="true"></i>
              </router-link>
            </li>
            <li class="mobile-compare"> 
              <router-link :to="{ path: '/account/compare' }">
                <i class="fa fa-retweet" aria-hidden="true"></i>
              </router-link>
            </li>
            <li class="onhover-dropdown mobile-account">
              <i class="fa fa-user" aria-hidden="true"></i> My Account

              <ul class="onhover-show-div">
                <li>
                  <a v-if="isLogin" v-on:click="logout"> Logout </a>
                  <router-link v-else :to="{ path: '/account/login' }"
                    >Login</router-link
                  >
                </li>
                <li v-if="isLogin">
                  <router-link :to="{ path: '/account/dashboard' }">
                    Dashboard
                  </router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  created() {},
  computed: {
    isLogin() {
      return this.$store.state.isLogin;
    },
    companyinfo() {
      return this.$store.state.companyInfo;
    },
  },
  methods: {
    logout() {
      sessionStorage.removeItem("loginInfo");
      this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
      this.$store.commit("UPDATE_ISLOGIN", false);
      this.isAuthenticated = false;
      this.$router.push("/account/login").catch(() => {});
      //   location.reload();
    },
  },
};
</script>
