<template>
  <div>
    <section class="ratio_square">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="title4">
              <h2 class="title-inner4">{{ title }}</h2>
              <div class="line">
                <span></span>
              </div>
            </div>
            <div v-swiper:mySwiper="swiperOption">
              <div class="swiper-wrapper">
                <div class="swiper-slide" v-for="(product, index) in products" :key="index">
                  <div class="product-box product-wrap">
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
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import productBox4 from '../../../../components/product-box/product-box4'
export default {
  props: ['products', 'imageSrc'],
  components: {
    productBox4
  },
  data() {
    return {
      title: 'top collection',
      subtitle: 'special offer',
      showquickviewmodel: false,
      quickviewproduct: {},
      description: '',
      swiperOption: {
        slidesPerView: 4,
        spaceBetween: 20,
        freeMode: false,
        breakpoints: {
          1199: {
            slidesPerView: 4,
            spaceBetween: 20
          },
          991: {
            slidesPerView: 3,
            spaceBetween: 20
          },
          420: {
            slidesPerView: 1,
            spaceBetween: 20
          },
          0: {
            slidesPerView: 1,
            spaceBetween: 20
          },
        }
      }
    }
  },
  computed: {

  },
  created() {

  },
  mounted() {

  },
  methods: {
    showquickview(item, productData) {
      this.showquickviewmodel = item
      this.quickviewproduct = productData
      this.$emit('openQuickview', this.showquickviewmodel, this.quickviewproduct)
    },
  }
}
</script>
