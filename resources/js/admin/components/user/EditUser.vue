<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit User" btnRoute="users" btnName="Users" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateUser($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>First Name <span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('first_name')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.first_name" placeholder="First Name" />
                            <p class="text-danger" v-if="checkError('first_name')" v-for="first_name in errors.first_name">
                                {{ first_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Last Name </label>
                            <input type="text" class="form-control" v-model="user_data.last_name" placeholder="Last Name" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" :class="checkError('email')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.email" placeholder="Email" />
                            <p class="text-danger" v-if="checkError('email')" v-for="email in errors.email">
                                {{ email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('password')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.password" placeholder="Password" />
                            <p class="text-danger" v-if="checkError('password')" v-for="password in errors.password">
                                {{ password }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('phone')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.phone" placeholder="Phone" />
                            <p class="text-danger" v-if="checkError('phone')" v-for="phone in errors.phone">
                                {{ phone }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Company Name </label>
                            <input type="text" class="form-control" v-model="user_data.company_name" placeholder="Company Name" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="checkError('status')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="checkError('status')" v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Profile Type <span class="text-danger">*</span></label>
                            <select :class="checkError('user_profile_id')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="user_data.user_profile_id">
                                <option disabled value="">Select Type</option>
                                <option v-for="profile_type in profile_types" :value="profile_type.id" :key="profile_type.id">
                                    {{ profile_type.profile_name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('user_profile_id')" v-for="user_profile_id in errors.user_profile_id">
                                {{ user_profile_id }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('address')
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="user_data.address" placeholder="Address" />
                            <p class="text-danger" v-if="checkError('address')" v-for="address in errors.address">
                                {{ address }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Company Address</label>
                            <input type="text" class="form-control" v-model="user_data.comp_address" placeholder="Company Address" />
                        </div>
                    </div>
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
            user_data: {},
            profile_types: [],
        }
    },
    created() {
        this.getUser();
        this.getProfileTypes();
    },
    methods: {
        checkError(field) {
            if (!this.isEmpty(this.errors)) {
                if (field in this.errors) {
                    return true
                }
            }
            return false;
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getProfileTypes() {
            this.profile_types = await this.$root.getAllData(
                "/api/user/userprofiles"
            );
        },
        async getUser() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/users/${this.$route.params.id}`
            );
            this.user_data = data[0];
            this.loading = false;
        },
        updateUser(event) {
            this.$root.updateData(this.user_data, `/api/user/users/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "users",
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
        }
    }
}
</script>
