<template>
	<div class="col-lg-12">
		<div class="card m-b-30 mt-5">
			<div class="card-header d-flex justify-content-between align-items-center font-16 mt-0">
				<strong class="text-primary">Profile Information</strong>
			</div>
			<div class="card-body">
				<vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="2" color="#3f51b5" />
				<table class="table">
					<tr>
						<td><b>Name:</b> </td>
						<td>{{ profileInfo.full_name }}</td>
					</tr>
					<tr>
						<td><b>Email:</b> </td>
						<td>{{ profileInfo.email }}</td>
					</tr>
					<tr>
						<td><b>Phone:</b> </td>
						<td>{{ profileInfo.phone }}</td>
					</tr>
					<tr>
						<td><b>Profile Type:</b> </td>
						<td>{{ profileInfo.user_profile.profile_name }}</td>
					</tr>
					<tr>
						<td><b>Status:</b> </td>
						<td>{{ profileInfo.user_status.stat_desc }}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				profileInfo: {},
				loading: false,
			}
		},
		computed: {
			routeName() {
				return this.$route.name;
			}
		},
		created() {
			this.getUser();
		},
		methods: {
			async getUser() {
				this.loading = true;
				this.profileInfo = await this.$root.getAllData('/api/user');
				this.loading = false;
			},
		}
	}
</script>
