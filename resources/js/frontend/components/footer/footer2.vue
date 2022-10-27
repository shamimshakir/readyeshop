<template>
	<div>
		<!-- footer -->
		<footer>
			<div class="white-layout">
				<section class="p-0">
					<div class="container-fluid">
						<div class="row footer-theme2 section-light footer-border">
							<div class="col">
								<div class="footer-block">
									<div class="footer-container">
										<div class="footer-title footer-mobile-title">
											<h4>about</h4>
										</div>
										<div class="footer-contant">
											<div class="footer-logo">
												<img :src="companyimg+companyinfo.logo" class="img-fluid" alt />
											</div>
											<div class="social-white">
												<ul>
													<li v-for="(item, index) in socialitems">
														<a v-bind:href="item.url">
															<i v-bind:class="item.icon" aria-hidden="true"></i>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col form-p p-0">
								<div class="footer-block">
									<div class="subscribe-white">
										<h2>newsletter</h2>
										<form @submit.prevent="suscrives">
											<div class="form-group">
												<input type="text" class="form-control" id="exampleFormControlInput"
													placeholder="Enter your email" v-model="suscrived.email">
												<button type="submit" class="btn btn-solid black-btn">subscribe</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="footer-block">
									<div class="footer-container">
										<div class="footer-title">
											<h4>store information</h4>
										</div>
										<div class="footer-contant">
											<ul class="contact-details">
												<li>{{companyinfo.comp_address}}</li>
												<li>{{companyinfo.contact_phone}}</li>
												<li>
													Email Us:
													<a href="#">{{companyinfo.contact_email}}</a>
												</li>
												<li>Fax: {{companyinfo.contact_phone}}</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="white-layout box-layout">
				<div class="container">
					<section class="small-section">
						<div class="row footer-theme2">
							<div class="col">
								<div class="footer-link link-white">
									<div class="footer-title">
										<h4>my account</h4>
									</div>
									<div class="footer-contant">
										<ul>
											<li>
												<router-link :to="{ path: '/shop' }">
												    Shop
												</router-link>
											</li>
											<li>
												<a href="#">my order</a>
											</li>
											<li>
												<router-link :to="{ path: '/faq' }">
												    FAQ
												</router-link>
											</li>
											<li>
												<router-link :to="{ path: '/cart' }">
												    Cart
												</router-link>
											</li>
											<li>
												<router-link :to="{ path: '/account/wishlist' }">
												    WishList
												</router-link>
											</li>
											<li>
												<router-link :to="{ path: '/account/dashboard' }">
												    Dashboard
												</router-link>
											</li>
											<li>
												<router-link :to="{ path: '/contact' }">
												    Contact
												</router-link>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			<div class="sub-footer black-subfooter">
				<div class="container">
					<div class="row">
						<div class="col-xl-6 col-md-6 col-sm-12">
							<div class="footer-end">
								<p>
									<i class="fa fa-copyright" aria-hidden="true"></i> 2020-{{currentDate()}}
									{{companyinfo.company_name}}-All Rights Reserved
								</p>
							</div>
						</div>
						<div class="col-xl-6 col-md-6 col-sm-12">
							<div class="payment-card-bottom">
								<ul>
									<li v-for="(item, index) in paymentitems">
									    <a href="#">
									        <img :src="imageSrc+item.logo" alt />
									    </a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				socialitems: [],
				paymentitems: [],
				imageSrc: "",
				suscrived: {
					email: "",
				},
			};
		},
		created() {
			this.getSocialDetail();
			this.getpaymentDetail();
		},
		computed: {
			companyinfo() {
				return this.$store.state.companyInfo;
			},
			companyimg() {
				return this.$store.getters.companyImg;
			},
		},
		methods: {
			currentDate() {
				const current = new Date();
				let year = `${current.getFullYear()}`;
				return year;
			},
			async getpaymentDetail() {
			    let dataObj = {
			        status: 1
			    };
			    let paymentData = await this.$root.getFrontData(dataObj, `/api/paymenticon_param`);
			    this.paymentitems = paymentData.data.data;
			    this.imageSrc = paymentData.data.url;
			},
			async getSocialDetail() {
				let dataObj = {
					active_status: 1
				};
				let socialData = await this.$root.getFrontData(dataObj, `/api/social_param`);
				this.socialitems = socialData.data.data;
			},
			suscrives() {
				this.$root.getFrontData(this.suscrived, `/api/subscribes`)
					.then(res => {
						Vue.$toast.open({
							message: res.data.message,
							position: 'top-right',
							type: 'success',
							duration: 3000,
							dismissible: false,
						});
					}).catch(error => {
						console.dir(error);
						let res = JSON.parse(error.request.response);
						if (res.status == "error") {
							this.errors = JSON.parse(error.request.response).validation_errors;
							Vue.$toast.open({
								message: this.errors.email,
								position: 'top-right',
								type: 'warning',
								duration: 3000,
								dismissible: false,
							});

						} else {
							Vue.$toast.open({
								message: "Failed to Subscribe",
								position: 'top-right',
								type: 'warning',
								duration: 3000,
								dismissible: false,
							});
						}
					})
			},
		},
	}
</script>
