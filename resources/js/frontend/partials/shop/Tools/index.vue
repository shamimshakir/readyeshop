<template>
	<div class="tools-bg">
		<Header />
		<Slider />
		<Services />
		<About />
		<!-- <Category /> -->
		<ProductSlider :products="sliderProducts" :image-src="imageSrc" @openQuickview="showQuickview" />
		<SelectVehical :products="vehicalProducts" :image-src="imageSrc" @openQuickview="showQuickview" />
		<ProducttabSlider :tabCategory="tabCategory" @openQuickview="showQuickview" />
		<LogoSlider />
		<Footer />
		<quickviewModel :openModal="showquickviewmodel" :productData="quickviewproduct" :image-src="imageSrc" />
		<!-- <newsletterModel /> -->
	</div>
</template>

<script>
	import Header from '../../../components/header/header5'
	import Footer from '../../../components/footer/footer5'
	import quickviewModel from '../../../components/widgets/quickview'
	// import newsletterModel from '../../../components/widgets/newsletter-popup'
	import Slider from './components/slider'
	import Services from './components/service'
	import About from './components/about'
	// import Category from './components/category'
	import ProductSlider from './components/product-slider'
	import SelectVehical from './components/select-vehical'
	import ProducttabSlider from './components/product-tab-slider'
	import LogoSlider from './components/logo_slider'
	export default {
		components: {
			Header,
			Slider,
			Services,
			About,
			// Category,
			ProductSlider,
			SelectVehical,
			ProducttabSlider,
			LogoSlider,
			Footer,
			quickviewModel,
			// newsletterModel
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
				meta: {},
				sliderProducts: [],
				vehicalProducts: [],
				imageSrc: "",
				showquickviewmodel: false,
				quickviewproduct: {},
			}
		},
		created() {
			this.getProductSliderProducts();
			this.getVehicalProducts();
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
	}
</script>
