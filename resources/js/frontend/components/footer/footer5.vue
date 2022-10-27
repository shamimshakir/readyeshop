<template>
	<div>
		<footer class="sticky-footer">
			<section class="section-b-space darken-layout">
				<div class="container">
					<div class="row footer-theme partition-f">
						<div class="col-lg-4 col-md-6">
							<div class="footer-title footer-mobile-title">
								<h4>about</h4>
							</div>
							<div class="footer-contant">
								<div class="footer-logo">
									<img :src="companyimg+companyinfo.logo" alt="logo" />
								</div>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
									incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
								<div class="footer-social">
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
						<div class="col offset-xl-1">
							<div class="sub-title">
								<div class="footer-title">
									<h4>my account</h4>
								</div>
								<div class="footer-contant">
									<ul>
										<li>
											<a href="#">mens</a>
										</li>
										<li>
											<a href="#">womens</a>
										</li>
										<li>
											<a href="#">clothing</a>
										</li>
										<li>
											<a href="#">accessories</a>
										</li>
										<li>
											<a href="#">featured</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="sub-title">
								<div class="footer-title">
									<h4>why we choose</h4>
								</div>
								<div class="footer-contant">
									<ul>
										<li>
											<a href="#">shipping &amp; return</a>
										</li>
										<li>
											<a href="#">secure shopping</a>
										</li>
										<li>
											<a href="#">gallary</a>
										</li>
										<li>
											<a href="#">affiliates</a>
										</li>
										<li>
											<a href="#">contacts</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col">
							<div class="sub-title">
								<div class="footer-title">
									<h4>store information</h4>
								</div>
								<div class="footer-contant">
									<ul class="contact-list">
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
			</section>
			<div class="sub-footer dark-subfooter">
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
