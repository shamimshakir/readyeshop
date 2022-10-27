<template>
	<!-- collection banner -->
	<section class="section-b-space p-t-0 ratio_40">
		<div class="container">
			<div class="row partition2">
				<div class="col-md-6" v-for="(item, index) in promotion" :key="index">
					<router-link :to="{ path: '/collection/leftsidebar/all'}">
						<div class="collection-banner p-right text-center">
							<div class="img-part">
								<img :src="imageSrc +item.image" class="img-fluid" alt />
							</div>
							<div class="contain-banner">
								<div>
									<h4>{{item.promotionpercent}}</h4>
									<h2>{{item.name}}</h2>
								</div>
							</div>
						</div>
					</router-link>
				</div>
			</div>
		</div>
	</section>
	<!-- collection banner end -->
</template>

<script type="text/javascript">
	export default {

		data() {
			return {
				promotion: [],
				imageSrc: "",
			}
		},
		created() {
			this.getAllPromotion();
		},
		methods: {
			async getAllPromotion() {
				let dataObj = {
					status: 1
				};
				let promotionData = await this.$root.getFrontData(dataObj, `/api/promotions_param`);
				this.promotion = promotionData.data.data;
				this.imageSrc = promotionData.data.url;
			}
		}
	}
</script>
