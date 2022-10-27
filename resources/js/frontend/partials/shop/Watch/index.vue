<template>
  <div>
    <Header />
    <Slider />
    <!-- <LogoSlider /> -->
    <!-- <TimerBanner /> -->
    <!-- <Category /> -->
    <CategoryTab :category="tabCategory" @openQuickview="showQuickview"  />
    <ProductSlider
      :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview"
    />
    <!-- <CollectionBanner /> -->
    <TopProducts @openQuickview="showQuickview"/>
    <Blog />
    <Services />
    <!-- <Instagram /> -->
    <Footer />
    <quickviewModel
      :openModal="showquickviewmodel" :productData="quickviewproduct" :image-src="imageSrc"
    />
  </div>
</template>

<script>
import Header from "../../../components/header/header4";
import Footer from "../../../components/footer/footer4";
import quickviewModel from "../../../components/widgets/quickview";
import Slider from "./components/slider";
// import LogoSlider from "./components/logo_slider";
// import TimerBanner from "./components/timer_banner";
// import Category from "./components/category";
import CategoryTab from "./components/categorytabs";
import ProductSlider from "./components/product_slider";
// import CollectionBanner from "./components/collectionbanners";
import TopProducts from "./components/top_products";
import Blog from "./components/blog";
import Services from "./components/services";
// import Instagram from "./components/instagram";
export default {
  components: {
    Header,
    Slider,
    // LogoSlider,
    // TimerBanner,
    // Category,
    CategoryTab,
    ProductSlider,
    // CollectionBanner,
    TopProducts,
    Blog,
    Services,
    // Instagram,
    Footer,
    quickviewModel
  },
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
            'status': '1'
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
};
</script>
