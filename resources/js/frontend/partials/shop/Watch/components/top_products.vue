<template>
  <div>
    <section class="section-b-space">
      <div class="full-box">
        <div class="container">
          <div class="title4">
            <h2 class="title-inner4">{{ title }}</h2>
            <div class="line">
              <span></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="theme-card center-align">
                <div class="offer-slider">
                  <div class="sec-1">
                    <div
                      v-for="(product, index) in specialProducts.slice(0, 2)"
                      :key="index"
                      class="product-box2"
                    >
                      <div class="media">
                        <router-link
                          :to="{
                            name: 'productdetails',
                            params: {
                              pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
                              id: product.id,
                            },
                          }"
                        >
                          <img
                            :id="product.id"
                            :src="imageSrc + product.pd_thumbnail"
                            class="img-fluid bg-img"
                            :alt="product.pd_name"
                          />
                        </router-link>
                        <div class="media-body align-self-center">
                          <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                          </div>
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
                          <h4 v-if="product.onsale_stat">
                            {{ currency + product.pd_price }}
                            <del>{{ currency + product.pd_prev_price }}</del>
                          </h4>
                          <h4 v-else>{{ currency + product.pd_price }}</h4>
                          <ul class="color-variant" v-if="product.productcolors.length > 0">
                            <li
                              v-for="(variant, variantIndex) in product.productcolors"
                              :key="variantIndex"
                            >
                              <a
                                :class="[variant.color.color_name]"
                                v-bind:style="{ 'background-color': variant.color.color_name }"
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 center-slider">
              <div>
                <div class="offer-slider">
                  <div>
                    <div
                      class="product-box product-wrap"
                      v-for="(product, index) in specialProducts.slice(2, 3)"
											:key="index"
                    >
                      <productBox4
                        @openquickview="showquickview"
												:product="product"
												:index="index"
												:image-src="imageSrc"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="theme-card center-align">
                <div class="offer-slider">
                  <div class="sec-1">
                    <div
                      class="product-box2"
                      v-for="(product, index) in specialProducts.slice(0, 2)"
                      :key="index"
                    >
                      <div class="media">
                        <router-link
                          :to="{
                            name: 'productdetails',
                            params: {
                              pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
                              id: product.id,
                            },
                          }"
                        >
                          <img
                            :id="product.id"
                            :src="imageSrc + product.pd_thumbnail"
                            class="img-fluid bg-img"
                            :alt="product.pd_name"
                          />
                        </router-link>
                        <div class="media-body align-self-center">
                          <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                          </div>
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
                          <h4 v-if="product.onsale_stat">
                            {{ currency + product.pd_price }}
                            <del>{{ currency + product.pd_prev_price }}</del>
                          </h4>
                          <h4 v-else>{{ currency + product.pd_price }}</h4>
                          <ul class="color-variant" v-if="product.productcolors.length > 0">
                            <li
                              v-for="(variant, variantIndex) in product.productcolors"
                              :key="variantIndex"
                            >
                              <a
                                :class="[variant.color.color_name]"
                                v-bind:style="{ 'background-color': variant.color.color_name }"
                              ></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import productBox4 from '../../../../components/product-box/product-box4'
export default {
  components: {
    productBox4
  },
  data() {
    return {
      title: 'POPULAR PRODUCTS',
      showquickviewmodel: false,
      quickviewproduct: {},
      swiperOption: {
        slidesPerView: 4,
        spaceBetween: 20,
        freeMode: true
      },
      specialProducts: [],
      imageSrc: "",
    }
  },
  created() {
    this.getSpecialProducts();
  },
  computed: {
    currency() {
      return this.$store.state.siteCurrency;
    },
  },
  methods: {
    async getSpecialProducts() {
      let dataObj = {
        'popular': '1',
        'status': '1'
        // 'category[]': 72
      };
      let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=8`);
      this.specialProducts = productsData.data.data.data;
      this.imageSrc = productsData.data.url;
    },
    showquickview(item, productData) {
      this.showquickviewmodel = item
      this.quickviewproduct = productData
      this.$emit('openQuickview', this.showquickviewmodel, this.quickviewproduct)
    },
  }
}
</script>
