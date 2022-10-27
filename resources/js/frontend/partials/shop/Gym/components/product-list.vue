<template>
  <div>
    <div class="title1 title-gradient section-t-space">
      <h4>{{ subtitle }}</h4>
      <h2 class="title-inner1">{{ title }}</h2>
    </div>
    <section class="p-t-0 section-b-space gym-product ratio_square">
      <div class="container">
        <div class="row partition-cls">
          <div
            class="col-xl-3 col-sm-6"
            v-for="(product, index) in products.slice(0, 8)"
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
    </section>
  </div>
</template>
<script>
import productBox9 from '../../../../components/product-box/product-box9'
export default {
  props: ['products', 'imageSrc'],
  components: {
    productBox9,
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
