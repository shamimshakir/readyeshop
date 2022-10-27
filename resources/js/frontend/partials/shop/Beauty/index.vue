<template>
<div>
    <Header />
    <Slider />
    <About />
    <ProductSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview" />
    <!-- <VideoTutorial /> -->
    <TopProductslider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview"  />
    <Blog />
    <!-- <Instagram /> -->
    <Footer />
    <quickviewModel :openModal="showquickviewmodel" :productData="quickviewproduct" :image-src="imageSrc" />
    <!-- <cartRightModel :openCart="showcartmodal" @closeCart="closeCart" /> -->
</div>
</template>
<script>
import Header from '../../../components/header/header1'
import Footer from '../../../components/footer/footer1'
import quickviewModel from '../../../components/widgets/quickview'
// import cartRightModel from '../../../components/cart-model/cart-right-model'
import Slider from './components/slider'
import About from './components/about'
import ProductSlider from './components/product-slider'
// import VideoTutorial from './components/video-tutorial'
import TopProductslider from './components/top-product-slider'
import Blog from './components/blog'
// import Instagram from './components/instagram'
export default {
  components: {
    Header,
    Slider,
    About,
    ProductSlider,
    // VideoTutorial,
    TopProductslider,
    Blog,
    // Instagram,
    Footer,
    quickviewModel,
    // cartRightModel,
  },
  data() {
    return {
      showcomparemodal: false,
      sliderProducts: [],
      meta: {},
      imageSrc: "",
      showquickviewmodel: false,
      quickviewproduct: {},
    }
  },
  created() {
    this.getProductSliderProducts();
  },
  methods: {
    async getMeta() {
        let dataObj = {
            'meta_page': 'home',
            'status': '1',
        };
        let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
        this.meta = metaData.data.data[0];
    },
    async getProductSliderProducts() {
        let dataObj = {
            'tag[]': '2',
        };
        let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=12`);
        //console.log(productsData);
        this.sliderProducts = productsData.data.data.data;
        this.imageSrc = productsData.data.url;
    },
    
    showQuickview(item, productData) {
        this.showquickviewmodel = item
        this.quickviewproduct = productData
    },
  },
  mounted() {},
  metaInfo() {
      return {            
          title:  this.meta.meta_name, 
          meta: [
              { name: 'description', content:  this.meta.meta_content},
              { name: 'keywords', content:  this.meta.meta_type},
              { property: 'og:title', content: this.meta.meta_content},
              { property: 'og:site_name', content: this.meta.meta_name},
              {property: 'og:type', content: 'website'},    
              {name: 'robots', content: 'index,follow'} 
          ]
      }
  }
}
</script>
