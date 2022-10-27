<template>
  <div>
      <section class="ratio_asos">
      <div class="container">
    <div class="col-12 product-related">
      <h2>{{ title }}</h2>
    </div>
        <div class="row m-0">
                <div 
                  class="col-xl-2 col-md-4 col-sm-6"
                  v-for="(product,index) in products"                  
                  :key="index"
                >
                  <div class="product-box">
                    <productBox1 :product="product" 
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

import productBox1 from '../product-box/product-box1'

export default {
  props: ['category'],
  components: {
    productBox1,    
  },
  data() {
    return {
      title: 'Related Products',
      products: [],
      showquickviewmodel: false,
      showcomparemodal: false,
      showcartmodal: false,
      quickviewproduct: {},
      comapreproduct: {},
      cartproduct: {},
      dismissSecs: 5,
      dismissCountDown: 0
    }
  },
  computed: {
    currency() {
            return this.$store.state.siteCurrency;
    },
  },
 
  created() {
        this.getRelatedProducts();
    },
  methods: {    
    discountedPrice(product) {
            const price = product.price - (product.price * product.discount / 100)
            return price;
    },
    async getRelatedProducts() {
            let dataObj = {
                'category[]': this.category,
            };
            let productData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=8`);
            
            this.products = productData.data.data.data;
            this.imageSrc = productData.data.url;
    },   
    
    
  }
}
</script>
