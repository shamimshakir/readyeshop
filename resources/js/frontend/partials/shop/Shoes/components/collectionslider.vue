<template>
	<div>
		<!-- product slider -->
		<section class="section-b-space">
			<div class="container">
				<div class="row multiple-slider">
					<div class="col-lg-3 col-sm-6" v-for="(collection,index) in tabProducts" :key="index">
						<div class="theme-card">
							<h5 class="title-border">{{collection.title}}</h5>
							<div class="offer-slider slide-1">
								<div v-swiper:[index]="swiperOption">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div>
												<div class="media"
													v-for="(product,index) in collection.products.slice(0, 3)"
													:key="index">
													<router-link :to="{ path: '/product/sidebar/'+product.id}">
														<img class="img-fluid" :src="imageSrc + product.pd_thumbnail"
															alt>
													</router-link>
													<div class="media-body align-self-center">
														<div class="rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<router-link :to="{ path: '/product/sidebar/'+product.id}">
															<h6>{{product.pd_name}}</h6>
														</router-link>
														<h4>{{ product.pd_price }}</h4>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide" v-if="collection.products.length >= 4">
											<div>
												<div class="media"
													v-for="(product,index) in collection.products.slice(3,6)"
													:key="index">
													<router-link :to="{ path: '/product/sidebar/'+product.id}">
														<img class="img-fluid" :src="imageSrc + product.pd_thumbnail"
															alt>
													</router-link>
													<div class="media-body align-self-center">
														<div class="rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<router-link :to="{ path: '/product/sidebar/'+product.id}">
															<h6>{{product.pd_name}}</h6>
														</router-link>
														<h4>{{ product.pd_price }}</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="swiper-button-prev" slot="button-prev">
										<i class="fa fa-angle-left" aria-hidden="true"></i>
									</div>
									<div class="swiper-button-next" slot="button-next">
										<i class="fa fa-angle-right" aria-hidden="true"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- product slider end -->
	</div>
</template>
<script>
	export default {
		props: ['category'],
		data() {
			return {
				swiperOption: {
					loop: false,
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev'
					}
				},
				showCart: false,
				showquickviewmodel: false,
				quickviewproduct: {},
				tabProducts: [],
				imageSrc: ""
			}
		},
		created() {
			this.getTabCategoryProducts();
		},
		methods: {
			async getTabCategoryProducts(value) {
				for (let cats of this.category) {
					let dataObj = {
						[cats.value]: 1
					}
					let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=6`);
					let productsArr = productsData.data.data.data;
					this.imageSrc = productsData.data.url;
					this.tabProducts.push({
						title: cats.name,
						label: cats.value,
						products: productsArr
					});
				}
			},
		}
	}
</script>
