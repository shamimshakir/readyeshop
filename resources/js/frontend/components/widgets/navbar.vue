<template>
  <div>
    <!-- Sample menu definition -->
    <div class="main-navbar">
      <div id="mainnav">
        <div class="toggle-nav" @click="changeRightSidebarVal(true)">
          <i class="fa fa-bars sidebar-bar"></i>
        </div>
        <ul class="nav-menu" :class="{ opennav: rightSidebarVal }" >
          <li class="back-btn">
            <div class="mobile-back text-right">
              <span @click="changeRightSidebarVal(false)">Back</span>
              <i class="fa fa-angle-right pl-2" aria-hidden="true"></i>
            </div>
          </li>
          <!-- <li class="dropdown">
						<a href="#" class="nav-link" @click="setActive(menuItem.title)">
							Home
							<span class="sub-arrow"></span>
						</a>
						<ul class="nav-submenu">
							<li><router-link :to="{ path: '/' }">Fashion 1</router-link></li>
							<li><router-link :to="{ path: '/home-fashion-2' }">Fashion 2</router-link></li>
						</ul>
					</li>  -->
					<li><router-link :to="{ path: '/' }">Home</router-link></li>
					<li><router-link :to="{ path: '/shop' }">Shop</router-link></li>
					<li><router-link :to="{ path: '/about' }">About us</router-link></li>
					<li><router-link :to="{ path: '/faq' }">FAQ</router-link></li>
					<li><router-link :to="{ path: '/contact' }">Contact</router-link></li>
        </ul>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {

    }
  },
  computed: {
      rightSidebarVal(){
          return this.$store.state.rightSidebarVal;
      }
  },
  methods: {
    changeRightSidebarVal(value) {
				this.$store.commit("CHANGE_RIGHT_SIDEBAR", value);
			},
			// runRoute(path) {
			// 	this.$router.push(path);
			// 	this.$store.commit("CHANGE_RIGHT_SIDEBAR", false);
			// }
  }
}
</script>

<style lang="scss" scoped>
.toggle-nav {
  &.toggle-button {
    z-index: 1;
  }
}
</style>