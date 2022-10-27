<template>
  <div>
    <div class="title1 section-t-space title5">
      <h4>{{ subtitle }}</h4>
      <h2 class="title-inner1">{{ title }}</h2>
      <hr role="tournament6" />
    </div>
    <section class="p-t-0 j-box ratio_square">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="theme-tab">
              <b-tabs content-class="mt-3">
                <b-tab :title="tabItem.title" v-for="(tabItem, index) in tabProducts" :key="index">
                  <div class="no-slider row">
                    <div
                      class="product-box"
                      v-for="(tabPro, index) in tabItem.products"
                      :key="index"
                    >
                      <productBox8
                        @openquickview="showquickview"
                        :product="tabPro"
                        :index="index"
                        :image-src="imageSrc"
                      />
                    </div>
                  </div>
                </b-tab>
              </b-tabs>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script type="text/javascript">
import productBox8 from '../../../../components/product-box/product-box8'
export default {
  props: ['category'],
  components: {
    productBox8
  },
  data() {
    return {
      title: 'special products',
      subtitle: 'exclusive products',
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
    async getTabCategoryProducts(value) {
      for (let cats of this.category) {
        let dataObj = {
          [cats.value]: 1,
          // 'category[]': 71
        }
        let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=8`);
        let productsArr = productsData.data.data.data;
        this.imageSrc = productsData.data.url;
        this.tabProducts.push({
          title: cats.name,
          label: cats.value,
          products: productsArr
        });
      }
    },
    showquickview(item, productData) {
      this.showquickviewmodel = item
      this.quickviewproduct = productData
      this.$emit('openQuickview', this.showquickviewmodel, this.quickviewproduct)
    },
  }
}
</script>
