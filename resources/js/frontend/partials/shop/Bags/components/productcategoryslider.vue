<template>
  <div>
    <!-- product slider-->
    <section class="ratio_square">
      <div class="container">
        <div class="row partition3 partition_3" v-if="tabProducts.length">
          <div class="col-lg-4">
            <div class="theme-card card-border">
              <h5 class="title-border" v-if="tabProducts.length">{{ tabProducts[0].title }}</h5>
              <div class="offer-slider slide-1">
                <div v-swiper:mySwiper="swiperOption">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div>
                        <div
                          class="media"
                          v-for="(product, index) in tabProducts[0].products.slice(0, 4)"
                          :key="index"
                        >
                          <router-link :to="{ path: '/product/sidebar/' + product.id }">
                            <img class="img-fluid" :src="imageSrc + product.pd_thumbnail" alt />
                          </router-link>
                          <div class="media-body align-self-center">
                            <div class="rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                            <router-link :to="{ path: '/product/sidebar/' + product.id }">
                              <h6>{{ product.pd_name }}</h6>
                            </router-link>
                            <h4>{{ product.pd_price }}</h4>
                            <!-- <h4 v-if="product.sale">
                              {{ discountedPrice(product) * curr.curr | currency(curr.symbol) }}
                              <del>{{ product.price * curr.curr | currency(curr.symbol) }}</del>
                            </h4>
                            <h4 v-else>{{ product.price * curr.curr | currency(curr.symbol) }}</h4>-->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide" v-if="tabProducts[0].length >= 5">
                      <div>
                        <div
                          class="media"
                          v-for="(product, index) in tabProducts[0].products.slice(5, 9)"
                          :key="index"
                        >
                          <router-link :to="{ path: '/product/sidebar/' + product.id }">
                            <img class="img-fluid" :src="imageSrc + product.pd_thumbnail" alt />
                          </router-link>
                          <div class="media-body align-self-center">
                            <div class="rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                            <router-link :to="{ path: '/product/sidebar/' + product.id }">
                              <h6>{{ product.pd_name }}</h6>
                            </router-link>
                            <h4>{{ product.pd_price }}</h4>
                            <!-- <h4 v-if="product.sale">
                              {{ discountedPrice(product) * curr.curr | currency(curr.symbol) }}
                              <del>{{ product.price * curr.curr | currency(curr.symbol) }}</del>
                            </h4>
                            <h4 v-else>{{ product.price * curr.curr | currency(curr.symbol) }}</h4>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-button-prev" slot="button-prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                  </div>
                  <div class="swiper-button-next" slot="button-next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 center-slider border-0">
            <div>
              <div class="title2">
                <h4>on sale</h4>
                <h2 v-if="tabProducts.length" class="title-inner2">{{ tabProducts[1].title }}</h2>
              </div>
              <div class="offer-slider slide-1">
                <div v-swiper:mySwiper1="swiperOption1">
                  <div class="swiper-wrapper">
                    <div
                      class="swiper-slide"
                      v-for="(product, index) in tabProducts[1].products.slice(0, 4)"
                      :key="index"
                    >
                      <div>
                        <div class="product-box product-wrap">
                          <productBox3 :product="product" :index="index" :image-src="imageSrc" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-button-prev" slot="button-prev"></div>
                  <div class="swiper-button-next" slot="button-next"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="theme-card card-border">
              <h5 class="title-border" v-if="tabProducts.length">{{ tabProducts[2].title }}</h5>
              <div class="offer-slider slide-1">
                <div v-swiper:mySwiper="swiperOption">
                  <div class="swiper-wrapper">
                    <div class="swiper-slide">
                      <div>
                        <div
                          class="media"
                          v-for="(product, index) in tabProducts[2].products.slice(0, 4)"
                          :key="index"
                        >
                          <router-link :to="{ path: '/product/sidebar/' + product.id }">
                            <img class="img-fluid" :src="imageSrc + product.pd_thumbnail" alt />
                          </router-link>
                          <div class="media-body align-self-center">
                            <div class="rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                            <router-link :to="{ path: '/product/sidebar/' + product.id }">
                              <h6>{{ product.pd_name }}</h6>
                            </router-link>
                            <h4>{{ product.pd_price }}</h4>
                            <!-- <h4 v-if="product.sale">
                              {{ discountedPrice(product) * curr.curr | currency(curr.symbol) }}
                              <del>{{ product.price * curr.curr | currency(curr.symbol) }}</del>
                            </h4>
                            <h4 v-else>{{ product.price * curr.curr | currency(curr.symbol) }}</h4>-->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide" v-if="tabProducts[2].length >= 5">
                      <div>
                        <div
                          class="media"
                          v-for="(product, index) in tabProducts[2].products.slice(5, 9)"
                          :key="index"
                        >
                          <router-link :to="{ path: '/product/sidebar/' + product.id }">
                            <img class="img-fluid" :src="imageSrc + product.pd_thumbnail" alt />
                          </router-link>
                          <div class="media-body align-self-center">
                            <div class="rating">
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                              <i class="fa fa-star"></i>
                            </div>
                            <router-link :to="{ path: '/product/sidebar/' + product.id }">
                              <h6>{{ product.pd_name }}</h6>
                            </router-link>
                            <h4>{{ product.pd_price }}</h4>
                            <!-- <h4 v-if="product.sale">
                              {{ discountedPrice(product) * curr.curr | currency(curr.symbol) }}
                              <del>{{ product.price * curr.curr | currency(curr.symbol) }}</del>
                            </h4>
                            <h4 v-else>{{ product.price * curr.curr | currency(curr.symbol) }}</h4>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="swiper-button-prev" slot="button-prev">
                    <i class="fa fa-angle-left" aria-hidden="true"></i>
                  </div>
                  <div class="swiper-button-next" slot="button-next">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- product slider end-->
</template>
<script>
import productBox3 from '../../../../components/product-box/product-box3'
export default {
  props: ['category'],
  components: {
    productBox3
  },
  data() {
    return {
      tabCategory: [
        {
          name: "Popular",
          value: "1"
        },
        {
          name: "Featured",
          value: "4"
        },
        {
          name: "New",
          value: "3"
        },
      ],
      swiperOption: {
        loop: false,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      },
      swiperOption1: {
        loop: false,
        slidesPerView: 1,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      },
      showCart: false,
      showquickviewmodel: false,
      quickviewproduct: {},
      tabProducts: [],
      imageSrc: ""
    }
  },
  created() {
    this.getTabCategoryProducts();
  },
  methods: {
    async getTabCategoryProducts() {
      for (let cats of this.tabCategory) {
        let dataObj = {
          [cats.value]: 1,
          // 'category[]': 71
        }
        let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=6`);
        let productsArr = productsData.data.data.data;
        this.imageSrc = productsData.data.url;
        this.tabProducts.push({
          title: cats.name,
          label: cats.value,
          products: productsArr
        });
      }
    },
  }
}
</script>
