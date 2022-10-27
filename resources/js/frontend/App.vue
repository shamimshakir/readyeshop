<template>
	<transition name="fade" mode="out-in">
		<router-view :key="$route.fullPath"></router-view>
	</transition>
</template>


<script>
export default {
  data() {
    return {};
  },
  mounted() {
    this.$store.dispatch("getCompanyInfos");
    this.$store.dispatch("getCartItems");
  },
  created() {
    this.setSessionID();
    this.checkTokenAvailability();
  },
  methods: {
    checkTokenAvailability() {
      let sessionData = JSON.parse(sessionStorage.getItem("loginInfo"));
      if (sessionData) {
        this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", sessionData.token);
        this.$store.commit("UPDATE_ISLOGIN", true);
      }
    },
    setSessionID() {
      if (!sessionStorage["session_id"]) {
        var randomChars =
          "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var result = "";
        var length = 20;
        for (var i = 0; i < length; i++) {
          result += randomChars.charAt(
            Math.floor(Math.random() * randomChars.length)
          );
        }
        let sessionObj = {
          id: result,
        };
        sessionStorage.setItem("session_id", JSON.stringify(sessionObj));
      }
    },
  },
};
</script>

<style>
/* .fade-enter-active,
.fade-leave-active {
    transition-property: opacity;
    transition-duration: .25s;
}

.fade-enter-active {
    transition-delay: .25s;
} */

/**** modified ****/


.fade-enter {
  opacity: 0;
}

.fade-enter-active {
  transition: opacity 0.3s ease;
}

.fade-leave-active {
  transition: opacity 0.3s ease;
  opacity: 0;
}
</style>
