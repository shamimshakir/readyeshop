<template>
  <div>
    <!-- <header class="header-5" :class="{ 'header5-absolute': $nuxt.$route.name == 'shop-jewellery' }"> -->
    <header class="header-5 header5-absolute">
      <div class="mobile-fix-option"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="main-menu">
              <div class="menu-left">
                <div class="brand-logo">
                  <router-link :to="{ path: '/' }" exact>
                    <img :src="companyimg + companyinfo.logo" class="img-fluid" alt />
                  </router-link>
                </div>
              </div>
              <div class="menu-right pull-right">
                <Nav />
                <div class="top-header">
                  <ul class="header-dropdown">
                    <li class="mobile-wishlist">
                      <router-link :to="{ path: '/account/wishlist' }">
                        <img :src="heartImg" />
                      </router-link>
                    </li>
                    <li class="onhover-dropdown mobile-account">
                      <img :src="avaterImg" alt />
                      <ul class="onhover-show-div">
                        <li>
                          <router-link :to="{ path: '/account/login' }">Login</router-link>
                        </li>
                        <li>
                          <router-link :to="{ path: '/page/account/dashboard' }">Dashboard</router-link>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
                <div>
                  <div class="icon-nav">
                    <ul>
                      <li class="onhover-div mobile-search">
                        <div>
                          <img :src="searchImg" @click="openSearch()" class="img-fluid" alt />
                          <i class="ti-search" @click="openSearch()"></i>
                        </div>
                        <div
                          id="search-overlay"
                          class="search-overlay"
                          :class="{ opensearch: search }"
                        >
                          <div>
                            <span class="closebtn" @click="closeSearch()" title="Close Overlay">×</span>
                            <div class="overlay-content">
                              <div class="container">
                                <div class="row">
                                  <div class="col-xl-12">
                                    <form>
                                      <div class="form-group mb-0">
                                        <input
                                          ype="text"
                                          class="form-control"
                                          v-model="searchString"
                                          placeholder="Search a Product"
                                        />
                                      </div>
                                      <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                      </button>
                                    </form>
                                    <ul class="search-results" v-if="searchItems.length">
                                      <li
                                        v-for="(product, index) in searchItems"
                                        :key="index"
                                        class="product-box"
                                      >
                                        <div class="img-wrapper">
                                          <img
                                            :src="imageSrc + product.pd_thumbnail"
                                            class="img-fluid bg-img"
                                            :key="index"
                                          />
                                        </div>
                                        <div class="product-detail">
                                          <router-link
                                            :to="{
                                              name: 'productdetails',
                                              params: {
                                                pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
                                                id: product.id,
                                              },
                                            }"
                                          >
                                            <h6>{{ product.pd_name }}</h6>
                                          </router-link>
                                          <h4>{{ currency }}{{ product.pd_price }}</h4>
                                        </div>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </li>
                      <li class="onhover-div mobile-setting">
                        <div>
                          <img
                          :src="controlsImg"
                          class="img-fluid"
                          alt
                          />
                          <i
                            class="ti-settings"
                          ></i>
                        </div>
                        <div class="show-div setting">
                          <h6>currency</h6>
                          <ul class="list-inline">
                            <li>
                              <a href="javascript:void(0)">eur</a>
                            </li>
                            <li>
                              <a href="javascript:void(0)" >inr</a>
                            </li>
                            <li>
                              <a href="javascript:void(0)" >gbp</a>
                            </li>
                            <li>
                              <a href="javascript:void(0)" >usd</a>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <li class="onhover-div mobile-cart">
                        <div>
                          <img :src="cartImg" class="img-fluid" alt="cart" />
                          <i class="ti-shopping-cart"></i>
                          <span class="cart_qty_cls">{{ cartItemCount }}</span>
                        </div>
                        <ul class="show-div shopping-cart" v-if="!cartItemCount">
                          <li>Your cart is currently empty.</li>
                        </ul>
                        <ul class="show-div shopping-cart">
                          <li v-for="(item, index) in cartItems" :key="index">
                            <div class="media">
                              <router-link :to="{ path: '/product/sidebar/' + item.id }">
                                <img
                                  alt
                                  class="mr-3"
                                  :src="cartImgSrc + item.products.pd_thumbnail"
                                />
                              </router-link>
                              <div class="media-body">
                                <router-link :to="{ path: '/product/sidebar/' + item.id }">
                                  <h4>{{ item.products.pd_name }}</h4>
                                </router-link>
                                <h4>
                                  <span>
                                    {{ item.ct_qty }} x {{
                                      currency
                                    }}{{ item.products.pd_price }}
                                  </span>
                                </h4>
                              </div>
                            </div>
                            <div class="close-circle">
                              <span @click="removeCartItem(item.id)">
                                <i class="fa fa-times" aria-hidden="true"></i>
                              </span>
                            </div>
                          </li>
                          <li>
                            <div class="total">
                              <h5>
                                subtotal :
                                <span>{{ currency }}{{ cartTotal }}</span>
                              </h5>
                            </div>
                          </li>
                          <li>
                            <div class="buttons">
                              <router-link :to="{ path: '/cart' }" :class="'view-cart'">view cart</router-link>
                              <router-link :to="{ path: '/checkout' }" :class="'checkout'">checkout</router-link>
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
  </div>
</template>
<script>
import Nav from '../widgets/navbar'
export default {
  components: {
    Nav
  },
  data() {
    return {
      search: false,
      searchString: '',
      searchItems: [],
      imageSrc: "",
      heartImg: '/frontimages/jewellery/icon/heart.png',
      avaterImg: '/frontimages/jewellery/icon/avatar.png',
      searchImg: '/frontimages/jewellery/icon/search.png',
      cartImg: '/frontimages/jewellery/icon/cart.png',
      controlsImg: '/frontimages/jewellery/icon/controls.png',
    }
  },
  computed: {
    companyinfo() {
      return this.$store.state.companyInfo;
    },
    companyimg() {
      return this.$store.getters.companyImg;
    },
    currency() {
      return this.$store.state.siteCurrency;
    },
    cartItems() {
      return this.$store.getters.cartProducts;
    },
    cartImgSrc() {
      return this.$store.getters.cartImgSrc;
    },
    cartTotal() {
      return this.$store.getters.cartTotal;
    },
    cartItemCount() {
      return this.$store.getters.cartItemCount;
    },
  },
  watch: {
    searchString: function (val) {
      if (val) {
        let dataObj = {
          name: val
        }
        this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=20`).then(res => {
          this.searchItems = res.data.data.data;
          this.imageSrc = res.data.url;
        }).catch(err => {
          console.dir(err)
        });
      } else {
        this.searchItems = [];
      }
    }
  },
  methods: {
    left_sidebar() {
      this.$store.commit("CHANGE_LEFT_SIDEBAR", true);
    },
    openSearch() {
      this.search = true;
    },
    closeSearch() {
      this.search = false;
      this.searchString = "";
    },
    async removeCartItem(cId) {
      this.$store.dispatch("removeCart", cId);
    },
  }
}
</script>