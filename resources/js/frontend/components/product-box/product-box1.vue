<template>
	<div>
		<div class="img-wrapper">
			<div class="lable-block">
				<span class="lable3" v-if="product.new_stat">new</span>
				<span class="lable4" v-if="product.onsale_stat">on sale</span>
			</div>
			<div class="front">
				<router-link
					:to="{
						name: 'productdetails',
						params: {
							pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
							id: product.id,
						},
					}"
				>
					<img
						:src="getActiveImage()"
						:id="product.id"
						class="img-fluid bg-img"
						:alt="product.title"
						:key="index"
					/>
				</router-link>
			</div>
			<ul class="product-thumb-list">
				<li
					class="grid_thumb_img"
					:class="{ active: image.isActive === true }"
					v-for="(image, index) in product__images"
					:key="index"
					@click="productVariantChange(image.id)"
				>
					<a href="javascript:void(0);">
						<img :src="image.image" />
					</a>
				</li>
			</ul>
			<div class="cart-info cart-wrap">
				<a href="javascript:void(0)" title="Add to cart">
					<i class="ti-shopping-cart" aria-hidden="true" @click="addItemToCart(product.id)"></i>
				</a>
				<a href="javascript:void(0)" title="Wishlist">
					<i class="ti-heart" aria-hidden="true" @click="addToWishlist(product.id)"></i>
				</a>
				<a
					href="javascript:void(0)"
					title="Quick View"
					@click="showQuickview(product)"
					variant="primary"
				>
					<i class="ti-search" aria-hidden="true"></i>
				</a>
				<a href="javascript:void(0)" title="Compare">
					<i class="ti-reload" aria-hidden="true" @click="addToCompare(product.id)"></i>
				</a>
			</div>
		</div>
		<div class="product-detail">
			<div class="rating">
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
				<i class="fa fa-star"></i>
			</div>
			<router-link
				:to="{
					name: 'productdetails',
					params: {
						pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
						id: product.id,
					},
				}"
			>
				<h6>{{ product.pd_name }}</h6>
			</router-link>
			<p>{{ product.product_detail }}</p>
			<h4 v-if="product.onsale_stat">
				{{ currency + product.pd_price }}
				<del>{{ currency + product.pd_prev_price }}</del>
			</h4>
			<h4 v-else>{{ currency + product.pd_price }}</h4>
			<ul class="color-variant" v-if="product.productcolors.length > 0">
				<li v-for="(variant, variantIndex) in product.productcolors" :key="variantIndex">
					<a
						:class="[variant.color.color_name]"
						v-bind:style="{ 'background-color': variant.color.color_name }"
					></a>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
export default {
	props: ["product", "index", "imageSrc"],
	data() {
		return {
			product__images: [],
			quickviewProduct: {},
			showquickview: false,
		};
	},
	watch: {
		product: function () {
			this.setProductImages();
		},
	},
	created() {
		this.setProductImages();
	},
	computed: {
		currency() {
			return this.$store.state.siteCurrency;
		},
	},
	methods: {
		setProductImages() {
			let prdt = this.product;
			let incrmntId = 1;
			this.product__images.splice(0);
			this.product__images.push({
				id: incrmntId,
				image: this.imageSrc + prdt.pd_thumbnail,
				isActive: true,
			});
			prdt.productimages.forEach((prImg, index) => {
				this.product__images.push({
					id: ++incrmntId,
					image: this.imageSrc + prImg.pro_img_name,
					isActive: false,
				});
			});
			return this.product__images;
		},
		getActiveImage() {
			let activeImage = "";
			for (let proImg of this.product__images) {
				if (proImg.isActive) {
					activeImage = proImg.image;
					break;
				}
			}
			return activeImage;
		},
		productVariantChange(id) {
			for (let proImg of this.product__images) {
				proImg.isActive = false;
			}
			for (let proImg of this.product__images) {
				if (proImg.id === id) {
					proImg.isActive = true;
				}
			}
		},
		addToWishlist: function (proId) {
			let session_id = JSON.parse(sessionStorage.getItem("session_id"));
			let sessionId = session_id.id;
			let dataObj = {
				pd_id: proId,
				session_id: sessionId,
			};
			this.$root
				.getFrontData(dataObj, `/api/wishlist`)
				.then((res) => {
					Vue.$toast.open({
						message: res.data.message,
						position: "top-right",
						type: "success",
						duration: 3000,
						dismissible: false,
					});
				})
				.catch((err) => {
					Vue.$toast.open({
						message: "Product Is not added to your wishlist.",
						position: "top-right",
						type: "error",
						duration: 3000,
						dismissible: false,
					});
				});
		},
		addItemToCart(proId) {
			let session_id = JSON.parse(sessionStorage.getItem("session_id"));
			let sessionId = session_id.id;
			let dataObj = {
				'pd_id': proId,
				'session_id': sessionId,
				'ct_qty': 1,
			}
			this.$store.dispatch("addToCart", dataObj);
		},
		addToCompare(proId) {
			let session_id = JSON.parse(sessionStorage.getItem("session_id"));
			let sessionId = session_id.id;
			let dataObj = {
				pd_id: proId,
				session_id: sessionId,
			};
			this.$root
				.getFrontData(dataObj, `/api/compare`)
				.then((res) => {
					Vue.$toast.open({
						message: res.data.message,
						position: "top-right",
						type: "success",
						duration: 3000,
						dismissible: false,
					});
				})
				.catch((err) => {
					Vue.$toast.open({
						message: "Product Is successfully added to your Compare list.",
						position: "top-right",
						type: "error",
						duration: 3000,
						dismissible: false,
					});
				});
			/*Vue.$toast.open({
					  message: "Product Is successfully added to your Compare list.",
					  position: 'top-right',
					  type: 'success',
					  duration: 3000,
					  dismissible: false,
				  })*/
		},
		showQuickview: function (productData) {
			this.showquickview = true;
			this.quickviewProduct = productData;
			this.$emit("openquickview", this.showquickview, this.quickviewProduct);
		},
	},
};
</script>
