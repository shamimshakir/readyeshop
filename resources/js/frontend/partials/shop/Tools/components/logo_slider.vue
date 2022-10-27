<template>
	<div v-if="checkAvailability">
		<section class="section-b-space tools-brand">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="brand-6 no-arrow">
							<div v-swiper:mySwiper="swiperOption">
								<div class="swiper-wrapper">
									<div class="swiper-slide" v-for="(logoItem, index) in logoItems" :key="index">
										<div>
											<div class="logo-block text-center">
												<a href="#">
													<img :src="imageSrc+logoItem.logo" alt />
												</a>
											</div>
										</div>
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
<script type="text/javascript">
	export default {
		data() {
			return {
				swiperOption: {
					slidesPerView: 6,
					freeMode: true,
					checkAvailability: 0,
					breakpoints: {
						1199: {
							slidesPerView: 4
						},
						768: {
							slidesPerView: 4
						},
						420: {
							slidesPerView: 3
						},
						0: {
							slidesPerView: 2,
						}
					}
				},
				logoItems: [],
				imageSrc: "",
			}
		},
		created() {
			this.getLogos();
		},
		methods: {
			async getLogos() {
				let dataObj = {
					status: 1
				};
				let logoData = await this.$root.getFrontData(dataObj, `/api/sponsor_param`);
				this.logoItems = logoData.data.data;
				this.checkAvailability = logData.data.count;
				this.imageSrc = logoData.data.url;
			},
		},
	}
</script>

<style>
	.logo-block.text-center a img {
	    max-width: 125px;
	    max-height: 125px;
	}
	
	.logo-block.text-center {
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
</style>