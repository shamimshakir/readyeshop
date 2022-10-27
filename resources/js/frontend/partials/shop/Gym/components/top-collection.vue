<template>
  <div>
    <div
      class="full-banner gym-parallax parallax p-0"
      v-bind:style="{ 'background-image': `url(https://vue.pixelstrap.com/multikart/_nuxt/img/25.c405366.jpg)` }"
    >
      <div class="section-t-space section-b-space gym-product">
        <div class="container">
          <div class="title1 title-gradient">
            <h4>{{ subtitle }}</h4>
            <h2 class="title-inner1">{{ title }}</h2>
          </div>
          <div class="row">
            <div class="col-lg-6 offset-lg-3">
              <div class="product-para">
                <p class="text-center">{{ description }}</p>
              </div>
            </div>
          </div>
          <div class="row part-cls">
            <div
              class="col-xl-3 col-sm-6"
              v-for="(product, index) in products.slice(0, 4)"
              :key="index"
            >
              <div class="product-box">
                <productBox9
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
</template>
<script>
import productBox9 from '../../../../components/product-box/product-box9'
export default {
  props: ['products', 'imageSrc'],
  components: {
    productBox9
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
  methods: {
    showquickview(item, productData) {
      this.showquickviewmodel = item
      this.quickviewproduct = productData
      this.$emit('openQuickview', this.showquickviewmodel, this.quickviewproduct)
    },
  }
}
</script>
