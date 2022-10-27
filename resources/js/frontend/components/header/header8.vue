<template>
  <div>
    <header class="header-2 header-6">
      <div class="mobile-fix-option"></div>
      <TopBar />

      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="main-menu border-section border-top-0">
              <div class="brand-logo layout2-logo">
                <router-link :to="{ path: '/' }" exact>
                  <img :src="companyimg + companyinfo.logo" class="img-fluid" alt />
                </router-link>
              </div>
              <div class="pets-search">
                <form class="form_search" role="form">
                  <input
                    type="search"
                    class="nav-search nav-search-field"
                    v-model="searchString"
                    placeholder="Find the best for your pet..."
                  />
                  <button type="submit" name="nav-submit-button" class="btn-search">
                    <i class="ti-search"></i>
                  </button>
                </form>
                <ul class="search-results" v-if="searchItems.length">
                  <li v-for="(product, index) in searchItems" :key="index" class="product-box">
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

              <div class="menu-right pull-right">
                <div class="icon-nav">
                  <ul>
                    <li class="onhover-div mobile-search">
                      <div>
                        <img
                          src="https://vue.pixelstrap.com/multikart/_nuxt/img/search.4381799.png"
                          class="img-fluid"
                          alt
                        />
                        <i class="ti-search"></i>
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
                                        type="text"
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
                    <!-- <li class="onhover-div mobile-setting">
                      <div>
                        <img :src=""@/assets/images/icon/setting.png"" class="img-fluid" alt />
                        <i class="ti-settings"></i>
                      </div>
                      <div class="show-div setting">
                        <h6>language</h6>
                        <ul>
                          <li>
                            <nuxt-link class="navbar-item" to="/fr">Français</nuxt-link>
                          </li>
                          <li>
                            <nuxt-link class="navbar-item" to="/en">English</nuxt-link>
                          </li>
                        </ul>
                        <h6>currency</h6>
                        <ul class="list-inline">
                          <li>
                            <a href="javascript:void(0)" @click="updateCurrency('eur', '€')">eur</a>
                          </li>
                          <li>
                            <a href="javascript:void(0)" @click="updateCurrency('inr', '₹')">inr</a>
                          </li>
                          <li>
                            <a href="javascript:void(0)" @click="updateCurrency('gbp', '£')">gbp</a>
                          </li>
                          <li>
                            <a href="javascript:void(0)" @click="updateCurrency('usd', '$')">usd</a>
                          </li>
                        </ul>
                      </div>
                    </li>-->
                    <li class="onhover-div mobile-cart">
                      <div>
                        <img
                          alt
                          src="https://vue.pixelstrap.com/multikart/_nuxt/img/cart.11c110d.png"
                          class="img-fluid"
                        />
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
                              <img alt class="mr-3" :src="cartImgSrc + item.products.pd_thumbnail" />
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

      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="main-nav-center">
              <Nav />
            </div>
          </div>
        </div>
      </div>
    </header>
  </div>
</template>
<script>
import TopBar from '../widgets/topbar'
import Nav from '../widgets/navbar'
export default {
  data() {
    return {
      search: false,
      searchString: '',
      searchItems: [],
      imageSrc: "",
    }
  },
  components: {
    TopBar,
    Nav
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
