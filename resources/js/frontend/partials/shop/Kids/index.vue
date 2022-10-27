<template>
  <div>
    <Header />
    <Slider />
    <CollectionBanner />
    <ProductSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview"  />
    <ParallaxBanner />
    <CollectionSlider  :category="tabCategory"  />
    <!-- <Instagram /> -->
    <LogoSlider />
    <Footer />
    <quickviewModel
      :openModal="showquickviewmodel"
      :productData="quickviewproduct"
      :image-src="imageSrc"
    />
  </div>
</template>
<script>
import Header from '../../../components/header/header1'
import Footer from '../../../components/footer/footer1'
import quickviewModel from '../../../components/widgets/quickview'
import Slider from './components/slider'
import CollectionBanner from './components/collection_banner'
import ProductSlider from './components/product_slider'
import ParallaxBanner from './components/parallax_banner'
import CollectionSlider from './components/collection_slider'
// import Instagram from './components/instagram'
import LogoSlider from './components/logo_slider'
export default {
  data() {
    return {
      tabCategory: [
        {
          name: "Featured",
          value: "4"
        },
        {
          name: "Popular",
          value: "1"
        },
        {
          name: "New",
          value: "3"
        },
        {
          name: "On Sale",
          value: "5"
        }
      ],
      sliderProducts: [],
      meta: {},
      imageSrc: "",
      showquickviewmodel: false,
      quickviewproduct: {},
    };
  },
  components: {
    Header,
    Footer,
    Slider,
    quickviewModel,
    CollectionBanner,
    ProductSlider,
    ParallaxBanner,
    CollectionSlider,
    // Instagram,
    LogoSlider
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
      let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=8`);
      //console.log(productsData);
      this.sliderProducts = productsData.data.data.data;
      this.imageSrc = productsData.data.url;
    },

    showQuickview(item, productData) {
      this.showquickviewmodel = item
      this.quickviewproduct = productData
    },
  },
  mounted() { },
  metaInfo() {
    return {
      title: this.meta.meta_name,
      meta: [
        { name: 'description', content: this.meta.meta_content },
        { name: 'keywords', content: this.meta.meta_type },
        { property: 'og:title', content: this.meta.meta_content },
        { property: 'og:site_name', content: this.meta.meta_name },
        { property: 'og:type', content: 'website' },
        { name: 'robots', content: 'index,follow' }
      ]
    }
  }
};
</script>
