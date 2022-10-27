<template>
	<div>
		<section class="section-b-space ratio_asos">
			<div class="container">
				<div class="title1">
					<h4>{{subtitle}}</h4>
					<h2 class="title-inner1">{{title}}</h2>
				</div>
				<div class="row">
					<div class="col-xl-6 offset-xl-3">
						<div class="product-para">
							<p class="text-center">{{description}}</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div v-swiper:mySwiper="swiperOption">
							<div class="swiper-wrapper">
								<div class="swiper-slide" v-for="(product,index) in products" :key="index">
									<div class="product-box">
										<productBox1 @openquickview="showquickview" :product="product" :index="index"
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
	import productBox1 from '../../../../components/product-box/product-box1'
	export default {
		props: ['products', 'imageSrc'],
		components: {
			productBox1,
		},
		data() {
			return {
				title: 'top collection',
				showCart: false,
				showquickviewmodel: false,
				showcomapreModal: false,
				quickviewproduct: {},
				comapreproduct: {},
				dismissSecs: 5,
				dismissCountDown: 0,
				swiperOption: {
					slidesPerView: 5,
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
