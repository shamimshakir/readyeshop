<template>
  <router-view />
</template>
<script>
export default {
  data() {
    return {
      
    };
  },
  created() {
    this.setHostUri();
    this.checkTokenAvailability();
  },
  methods: {
    setHostUri(){
      this.$store.commit("SET_HOST_NAME", localStorage.getItem('app_url'));
    },
    checkTokenAvailability() {
      let sessionData = JSON.parse(sessionStorage.getItem("loginInfo"));
      if (sessionData) {
        this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", sessionData.token);
      } else {
        this.$router.push("/login").catch(() => {});
      }
    },
  },
  mounted() {},
};
</script>
