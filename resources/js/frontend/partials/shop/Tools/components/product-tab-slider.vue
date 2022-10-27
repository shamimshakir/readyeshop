<template>
	<div>
		<section class="tools_product">
			<div class="container">
				<div class="row multiple-slider">
					<div class="col-xl-3 col-lg-4 col-md-12">
						<div class="theme-card">
							<h5 class="title-border" v-if="tabProducts.length > 0">{{tabProducts[0]['title']}}</h5>
							<div class="offer-slider slide-1">
								<div v-swiper:mySwiper="swiperOption">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div>
												<div class="media"
													v-if="tabProducts.length > 0"
													v-for="(product,index) in tabProducts[0].products.slice(0, 4)"
													:key="index">
													<router-link :to="{
														name: 'productdetails',
														params: {
														pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
														id: product.id,
														},
													}">
															<img :src="imageSrc+product.pd_thumbnail" :id="product.id" class="img-fluid" :alt="product.pd_name"
																:key="index" />
													</router-link>
													<div class="media-body align-self-center">
														<div class="rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<router-link :to="{
															name: 'productdetails',
															params: {
															pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
															id: product.id,
															},
														}">
															<h6>{{product.pd_name}}</h6>
														</router-link>
														<h4 v-if="product.onsale_stat">
															{{ currency + product.pd_price }}
															<del>{{ currency + product.pd_prev_price }}</del>
														</h4>
														<h4 v-else>{{ currency + product.pd_price }}</h4>
													</div>
												</div>
											</div>
										</div>
										<div class="swiper-slide" v-if="tabProducts[0].products.length >= 5">
											<div>
												<div class="media"
													v-if="tabProducts.length > 0"
													v-for="(product,index) in tabProducts[0].products.slice(4,8)"
													:key="index">
													<router-link :to="{
														name: 'productdetails',
														params: {
														pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
														id: product.id,
														},
													}">
														<img :src="imageSrc+product.pd_thumbnail" :id="product.id" class="img-fluid" :alt="product.pd_name"
															:key="index" />
													</router-link>
													<div class="media-body align-self-center">
														<div class="rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
														</div>
														<router-link :to="{
															name: 'productdetails',
															params: {
															pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
															id: product.id,
															},
														}">
															<h6>{{product.pd_name}}</h6>
														</router-link>
														<h4 v-if="product.onsale_stat">
															{{ currency + product.pd_price }}
															<del>{{ currency + product.pd_prev_price }}</del>
														</h4>
														<h4 v-else>{{ currency + product.pd_price }}</h4>
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
					<div class="col-xl-9 col-lg-8 col-md-12 tools-grey">
						<div class="theme-tab">
							<b-tabs content-class="mt-3">
								<b-tab v-for="(tabItem,index) in tabProducts.slice(1)" :key="index" :title="tabItem.title">
									<div class="no-slider row">
										<div class="product-box" v-for="(tabPro,index) in tabItem.products.slice(0, 4)"
											:key="index">
											<productBox7 @openquickview="showquickview" :product="tabPro" :index="index"
												:image-src="imageSrc" />
										</div>
									</div>
								</b-tab>
							</b-tabs>
						</div>
						<div class="banner-tools">
							<img src="https://vue.pixelstrap.com/multikart/_nuxt/img/banner.6d5e336.jpg" alt class="img-fluid" />
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>
<script type="text/javascript">
	import productBox7 from '../../../../components/product-box/product-box7'
	export default {
		props: ['tabCategory'],
		components: {
			productBox7
		},
		data() {
			return {
				swiperOption: {
					loop: false,
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev'
					}
				},
				imageSrc: "",
				tabProducts: [],
				quickviewProduct: {},
				showquickview: false,
			}
		},
		created() {
			this.getTabCategoryProducts();
		},
		computed: {
			currency() {
				return this.$store.state.siteCurrency;
			},
		},
		methods: {
			async getTabCategoryProducts(value) {
				for (let cats of this.tabCategory) {
					let dataObj = {
						[cats.value]: 1,
						// 'category[]': 79
					}
					let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=8`);
					let productsArr = productsData.data.data.data;
					this.imageSrc = productsData.data.url;
					this.tabProducts.push({
						title: cats.name,
						label: cats.value,
						products: productsArr
					});
				}
			},
			showQuickview: function(productData) {
				this.showquickview = true;
				this.quickviewProduct = productData;
				this.$emit("openquickview", this.showquickview, this.quickviewProduct);
			},
		}
	}
</script>
