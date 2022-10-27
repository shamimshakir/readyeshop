<template>
  <div>
    <Header />
    <Breadcrumbs title="Cart" />
    <section class="cart-section section-b-space">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <table
              class="table cart-table table-responsive-xs"
              v-if="cartItems.length"
            >
              <thead>
                <tr class="table-head">
                  <th scope="col">image</th>
                  <th scope="col">product name</th>
                  <th scope="col">price</th>
                  <th scope="col">quantity</th>
                  <th scope="col">action</th>
                  <th scope="col">total</th>
                </tr>
              </thead>
              <tbody v-for="(item, index) in cartItems" :key="index">
                <tr>
                  <td>
                    <router-link :to="{ path: '/product/sidebar/' + item.id }">
                      <img :src="cartImgSrc + item.products.pd_thumbnail" alt />
                    </router-link>
                  </td>
                  <td>
                    <router-link
                      :to="{ path: '/product/sidebar/' + item.id }"
                      >{{ item.products.pd_name }}</router-link
                    >
                    <div class="mobile-cart-content row">
                      <div class="col-xs-3">
                        <div class="qty-box">
                          <div class="input-group">
                            <span class="input-group-prepend">
                              <button
                                type="button"
                                class="btn quantity-left-minus"
                                data-type="minus"
                                data-field
                                @click="
                                  updateCartItems(
                                    item.pd_id,
                                    item.id,
                                    item.ct_qty - 1
                                  )
                                "
                              >
                                <i class="ti-angle-left"></i>
                              </button>
                            </span>
                            <input
                              type="text"
                              name="quantity"
                              class="form-control input-number"
                              :disabled="item.ct_qty > item.products.pd_qty"
                              v-model="item.ct_qty"
                            />
                            <span class="input-group-prepend">
                              <button
                                type="button"
                                class="btn quantity-right-plus"
                                data-type="plus"
                                data-field
                                @click="
                                  updateCartItems(
                                    item.pd_id,
                                    item.id,
                                    item.ct_qty + 1
                                  )
                                "
                              >
                                <i class="ti-angle-right"></i>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-3">
                        <h2 class="td-color">
                          {{ currency }}{{ item.products.pd_price }}
                        </h2>
                      </div>
                      <div class="col-xs-3">
                        <h2 class="td-color">
                          <a href="#" class="icon">
                            <i class="ti-close"></i>
                          </a>
                        </h2>
                      </div>
                    </div>
                  </td>
                  <td>
                    <h2>{{ currency }}{{ item.products.pd_price }}</h2>
                  </td>
                  <td>
                    <div class="qty-box">
                      <div class="input-group">
                        <span class="input-group-prepend">
                          <button
                            type="button"
                            class="btn quantity-left-minus"
                            data-type="minus"
                            data-field
                            @click="
                              updateCartItems(
                                item.pd_id,
                                item.id,
                                item.ct_qty - 1
                              )
                            "
                          >
                            <i class="ti-angle-left"></i>
                          </button>
                        </span>
                        <input
                          type="text"
                          name="quantity"
                          class="form-control input-number"
                          :disabled="item.ct_qty > item.products.pd_qty"
                          v-model="item.ct_qty"
                        />
                        <span class="input-group-prepend">
                          <button
                            type="button"
                            class="btn quantity-right-plus"
                            data-type="plus"
                            data-field
                            @click="
                              updateCartItems(
                                item.pd_id,
                                item.id,
                                item.ct_qty + 1
                              )
                            "
                          >
                            <i class="ti-angle-right"></i>
                          </button>
                        </span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <a class="icon" @click="deleteCartItem(item.id)">
                      <i class="ti-close"></i>
                    </a>
                  </td>
                  <td>
                    <h2 class="td-color">
                      {{ currency }}{{ item.ct_qty * item.products.pd_price }}
                    </h2>
                  </td>
                </tr>
              </tbody>
            </table>
            <table
              class="table cart-table table-responsive-md"
              v-if="cartItems.length"
            >
              <tfoot>
                <tr>
                  <td>total price :</td>
                  <td>
                    <h2>{{ currency }}{{ cartTotal }}</h2>
                  </td>
                </tr>
              </tfoot>
            </table>
            <div
              class="col-sm-12 empty-cart-cls text-center"
              v-if="!cartItems.length"
            >
              <img
                src="https://vue.pixelstrap.com/multikart/_nuxt/img/icon-empty-cart.e348b3a.png"
                class="img-fluid"
                alt="empty cart"
              />
              <h3 class="mt-3">
                <strong>Your Cart is Empty</strong>
              </h3>
              <h4 class="mb-3">Add something to make me happy :)</h4>
              <div class="col-12">
                <router-link :to="{ path: '/' }" class="btn btn-solid"
                  >continue shopping</router-link
                >
              </div>
            </div>
          </div>
        </div>
        <div class="row cart-buttons" v-if="cartItems.length">
          <div class="col-6">
            <router-link :to="{ path: '/' }" :class="'btn btn-solid'"
              >continue shopping</router-link
            >
          </div>
          <div class="col-6">
            <router-link :to="{ path: '/checkout' }" :class="'btn btn-solid'"
              >check out</router-link
            >
          </div>
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
    return {};
  },
  created() {},
  computed: {
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
  },
  methods: {
    async deleteCartItem(cId) {
      this.$store.dispatch("removeCart", cId);
    },
    async updateCartItems(pdId, cId, cQty) {
      let session_id = JSON.parse(sessionStorage.getItem("session_id"));
      let sessionId = session_id.id;
      let dataObj = {
        pd_id: pdId,
        session_id: sessionId,
        ct_qty: cQty,
        id: cId,
      };
      if (cQty) {
        this.$store.dispatch("updateCart", dataObj);
      }
    },
  },
  mounted() {},
};
</script>
