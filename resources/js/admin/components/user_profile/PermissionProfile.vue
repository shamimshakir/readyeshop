<template>
	<div class="col-lg-12">
		<div class="card m-b-30 mt-5">
			<CardHeader v-bind:title="'Profile Permission for '+profile.profile_name" btnRoute="user_profiles"
				btnName="Profiles" />
			<div class="card-body">
				<vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
				<form @submit.prevent="updateProfile($event)" v-bind:class="{ lessOpacity: loading }">
					<div class="row">
						<table class='table tree-2 table-bordered table-striped table-condensed'>
							<thead>
								<tr>
									<td>Module/Node</td>
									<td>View</td>
									<td>Add</td>
									<td>Edit</td>
									<td>Delete</td>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(profilepermission, pIndex) in profilepermissions" :key="profilepermission.id">
									<td>
										<strong
											v-if="profilepermission.haschild>0">{{profilepermission.nodename}}</strong>
										<span v-else>{{profilepermission.nodename}}</span>
									</td>
									<td>
										<input type='checkbox' :id="'p_view'+ profilepermission.id" v-model="p_view"
											:value="profilepermission.id" />
									</td>
									<td>
										<input v-if="profilepermission.haschild==0" type='checkbox'
										:disabled="checkView(profilepermission.id, pIndex)"
											:id="'p_add-'+ profilepermission.id" v-model="p_add"
											:value="profilepermission.id" />
									</td>
									<td>
										<input v-if="profilepermission.haschild==0" type='checkbox'
										:disabled="checkView(profilepermission.id, pIndex)"
											:id="'p_edit-'+ profilepermission.id" v-model="p_edit"
											:value="profilepermission.id" />
									</td>
									<td>
										<input v-if="profilepermission.haschild==0" type='checkbox'
										:disabled="checkView(profilepermission.id, pIndex)"
											:id="'p_delete-'+ profilepermission.id" v-model="p_delete"
											:value="profilepermission.id" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<button type="submit" class="btn btn-primary">Update</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	import CardHeader from "../basics/CardHeader";
	export default {
		components: {
			CardHeader,
		},
		data() {
			return {
				errors: [],
				loading: false,
				profile: {},
				profilepermissions: [],
				p_view: [],
				p_add: [],
				p_edit: [],
				p_delete: [],
			}
		},
		created() {
			this.getprofile();
			this.getprofilepermission();
		},
		methods: {
			isEmpty(obj) {
				return Object.keys(obj).length === 0;
			},
			checkView(id, idex){
				// return this.p_view[idex] != id;
				return false;
			},
			async getprofile() {
				this.profile = await this.$root.getAllData(
					`/api/user/userprofiles/${this.$route.params.id}`
				);
			},
			async getprofilepermission() {
				this.loading = true;
				let data = await this.$root.getAllData(
					`/api/user/profilepermission/${this.$route.params.id}`
				);
				this.profilepermissions = data;
				this.profilepermissions.forEach(per_id => {
					this.p_view.push(per_id.view);
					this.p_add.push(per_id.add);
					this.p_edit.push(per_id.edit);
					this.p_delete.push(per_id.delete);
				});
				this.loading = false;
			},
			updateProfile(event) {
				let per_form = {};
				per_form.profile_id = this.profile.id;
				per_form.views = [];
				per_form.adds = [];
				per_form.edits = [];
				per_form.deletes = [];
				
				this.p_view.forEach(view => {
					if(view){
						per_form.views.push(view)
					}
				});
				this.p_add.forEach(add => {
					if(add){
						per_form.adds.push(add);
					}
				});
				this.p_edit.forEach(edit => {
					if(edit){
						per_form.edits.push(edit);
					}
				});
				this.p_delete.forEach(del => {
					if(del){
						per_form.deletes.push(del);
					}
				});
				console.dir(per_form)
				this.$root.addData(per_form, "/api/user/profilepermission/update").then(response => {
					console.dir(response)
					this.$fire({
						title: response.data.message,
						type: "success",
						timer: 2000
					});
					this.$router.push({
						name: "user_profiles",
					});
					event.target.reset();
				}).catch(error => {
					let res = JSON.parse(error.request.response);
					console.dir(res)
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
		}
	}
</script>
