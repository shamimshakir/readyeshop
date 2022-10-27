<template>
  <div>
    <Header />
    <Slider />
    <Category />
    <ProductSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview"/>
    <Services />
    <Banner />
    <ProductTab :category="tabCategory" @openQuickview="showQuickview" />
    <!-- <Instagram /> -->
    <Footer />
    <quickviewModel
      :openModal="showquickviewmodel"
      :productData="quickviewproduct"
      :image-src="imageSrc"
    />
  </div>
</template>
<script>
import Header from '../../../components/header/header6'
import Footer from '../../../components/footer/footer2'
import quickviewModel from '../../../components/widgets/quickview'
import Slider from './components/slider'
import Category from './components/category'
import ProductSlider from './components/product-slider'
import Services from './components/services'
import Banner from './components/parallax-banner'
import ProductTab from './components/product-tab'
// import Instagram from './components/instagram'
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
    Slider,
    Category,
    ProductSlider,
    Services,
    Banner,
    ProductTab,
    // Instagram,
    Footer,
    quickviewModel,
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
}
</script>
