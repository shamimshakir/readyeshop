<template>
	<div>
		<section class="full-banner parallax small-slider tools-parallax-product">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-12">
						<div class="tools-description">
							<div>
								<h3>{{title}}</h3>
								<div class="tools-form">
									<div class="search-box">
										<select class="form-control">
											<option value>Select Make</option>
											<option value="1">Audi</option>
											<option value="2">BMW</option>
											<option value="3">Fiat</option>
											<option value="4">Hyndai</option>
											<option value="5">Skoda</option>
										</select>
									</div>
									<div class="search-box">
										<select name="model" class="form-control">
											<option value>Select Model</option>
										</select>
									</div>
									<div class="search-box">
										<select name="engine" class="form-control">
											<option value>Select category</option>
										</select>
									</div>
									<div class="search-box">
										<select name="year" class="form-control">
											<option value>Select Year</option>
										</select>
									</div>
									<div class="search-button">
										<a href="#" class="btn btn-solid btn-find">find my part</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-12 tools-grey ratio_square">
						<div v-swiper:mySwiper="swiperOption">
							<div class="swiper-wrapper">
								<div class="swiper-slide" v-for="(product,index) in products" :key="index">
									<div class="product-box">
										<productBox7 @openquickview="showquickview" :product="product" :index="index"
											:image-src="imageSrc" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>
<script>
	import productBox7 from '../../../../components/product-box/product-box7'
	export default {
		props: ['products', 'imageSrc'],
		components: {
			productBox7
		},
		data() {
			return {
				title: 'select your vehical',
				showquickviewmodel: false,
				quickviewproduct: {},
				swiperOption: {
					slidesPerView: 4,
					spaceBetween: 20,
					freeMode: true,
					breakpoints: {
						1199: {
							slidesPerView: 3,
							spaceBetween: 20
						},
						991: {
							slidesPerView: 2,
							spaceBetween: 20
						},
						420: {
							slidesPerView: 1,
							spaceBetween: 20
						},
						0: {
							slidesPerView: 1,
						}
					}
				}
			}
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

<style>
	.tools-parallax-product{
		background-image: url('https://vue.pixelstrap.com/multikart/_nuxt/img/21.631ed65.jpg');
	}
</style>