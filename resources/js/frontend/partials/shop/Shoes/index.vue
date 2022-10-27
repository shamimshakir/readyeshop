<template>
	<div>
		<Header />
		<Slider />
		<!-- <Category /> -->
		<!-- <About /> -->

		<!-- <CollectionBanner /> -->
		<productSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview" /> 
		<!-- <Category2 /> -->
		<!-- <CollectionSlider :category="tabCategory" /> -->
		<!-- <Category3 /> -->
		<CollectionTab :category="tabCategory" @openQuickview="showQuickview" />
		<Blog />
		<Service />
		<!-- <Instagram /> -->
		<!-- <Brand /> -->
		<Footer />
		<quickviewModel :openModal="showquickviewmodel" :productData="quickviewproduct" />
	</div>
</template>
<script>
import Header from "../../../components/header/header2";
import Footer from "../../../components/footer/footer2";
import quickviewModel from "../../../components/widgets/quickview";
import Slider from "./components/slider";
// import Category from "./components/category";
// import About from "./components/about";
// import CollectionBanner from "./components/collectionbanner";
import productSlider from "./components/productSlider";
// import Category2 from "./components/category2";
// import CollectionSlider from "./components/collectionslider.vue";
// import Category3 from "./components/category3";
import CollectionTab from "./components/collectiontab";
import Blog from "./components/blog";
import Service from "./components/service";
// import Instagram from "./components/instagram";
// import Brand from "./components/brand";
export default {
	components: {
		Header,
		Slider,
		// Category,
		// About,
		// CollectionBanner,
		productSlider,
		// Category2,
		// CollectionSlider,
		// Category3,
		CollectionTab,
		Blog,
		Service,
		// Instagram,
		// Brand,
		Footer,
		quickviewModel,
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
