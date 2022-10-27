<template>
	<div>
		<section class="section-b-space addtocart_count ratio_square">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="title4">
							<h2 class="title-inner4">{{title}}</h2>
							<div class="line">
								<span></span>
							</div>
						</div>
						<div v-swiper:mySwiper="swiperOption">
							<div class="swiper-wrapper">
								<div class="swiper-slide" v-for="(product,index) in products" :key="index">
									<div class="product-box">
										<productBox6 @openquickview="showquickview" :product="product" :index="index"
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
	import productBox6 from '../../../../components/product-box/product-box6'
	export default {
		props: ['products', 'imageSrc'],
		components: {
			productBox6
		},
		data() {
			return {
				title: 'top collection',
				showquickviewmodel: false,
				quickviewproduct: {},
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

