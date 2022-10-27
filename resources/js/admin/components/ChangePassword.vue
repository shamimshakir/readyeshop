<template>
	<div class="col-lg-12">
		<div class="card m-b-30 mt-5">
			<div class="card-header d-flex justify-content-between align-items-center font-16 mt-0">
				<strong class="text-primary">Password Change</strong> 
			</div>
			<div class="card-body">
				<form @submit.prevent="changePassword($event)">
					<div class="errorUl mb-4">
						<p class="text-danger" v-for="error in errors.password">{{ error }}</p>
						<p class="text-danger" v-for="error in errors.password_confirm">{{ error }}</p>
					</div>
					<div class="form-group">
						<label>Password<span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="passwordInput.password"
							placeholder="Password" />
					</div>
					<div class="form-group">
						<label>Confirm Password<span class="text-danger">*</span></label>
						<input type="text" class="form-control" v-model="passwordInput.password_confirm"
							placeholder="Confirm Password" />
					</div>
					<button type="submit" class="btn btn-primary">Update Password</button>
				</form>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		components: {

		},
		data() {
			return {
				passwordInput: {},
				errors: [],
			};
		},
		created() {

		},
		methods: {
			isEmpty(obj) {
				return Object.keys(obj).length === 0;
			},
			logout() {
				sessionStorage.removeItem("loginInfo");
				this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
				this.isAuthenticated = false;
				this.$router.push("/login").catch(() => {});
				location.reload();
			},
			changePassword() {
				this.$root.addData(this.passwordInput, `/api/user/change_password`).then(response => {
					this.$fire({
						title: response.data.message,
						type: "success",
						timer: 2000
					});
					this.logout();
				}).catch(error => {
					let res = JSON.parse(error.request.response);
					if (res.status == "error") {
						this.errors = JSON.parse(error.request.response).validation_errors;
					} else {
						this.$fire({
							title: "Failed to update",
							type: "warning",
							timer: 2000
						});
					}
				})
			},

		},
	};
</script>
