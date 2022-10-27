<template>
<div>
    <Slider />
    <CollectionBanner />
    <ProductSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview" />
    <Banner />
    <ProductTab :category="tabCategory" @openQuickview="showQuickview" />
    <Services />
    <Blog />
    <!-- <Instagram /> -->
    <LogoSlider />
    <quickviewModel :openModal="showquickviewmodel" :productData="quickviewproduct" :image-src="imageSrc" />
</div>
</template>

<script>
import Slider from '../partials/shop/fashion/components/slider'
import CollectionBanner from '../partials/shop/fashion/components/collection_banner'
import ProductSlider from '../partials/shop/fashion/components/product_slider'
import quickviewModel from '../components/widgets/quickview'
import Services from '../partials/shop/fashion/components/services'
import Blog from '../partials/shop/fashion/components/blog'
import Banner from '../partials/shop/fashion/components/banner'
import ProductTab from '../partials/shop/fashion/components/product_tab'
// import Instagram from '../partials/shop/fashion/components/instagram'
 import LogoSlider from '../partials/shop/fashion/components/logo_slider'

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
        Slider,
        CollectionBanner,
        ProductSlider,
        Banner,
        ProductTab,
        Services,
        Blog,
        // Instagram,
        LogoSlider,
        // Footer,
        quickviewModel,
        // compareModel,
        // cartModel,
        // newsletterModel
    },
    created() {
        this.getProductSliderProducts();
        this.getMeta();
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
