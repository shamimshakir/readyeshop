<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Profile" btnRoute="user_profiles" btnName="Profiles" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateProfile($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Profile Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !profile.profile_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="profile.profile_name" placeholder="Profile Name" />
                            <p class="text-danger" v-if="
                                errors.profile_name.length > 0 && !profile.profile_name
                            " v-for="profile_name in errors.profile_name">
                                {{ profile_name }}
                            </p>
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
            profile: {},
        }
    },
    created() {
        this.getprofile();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getprofile() {
            this.loading = true;
            this.profile = await this.$root.getAllData(
                `/api/user/userprofiles/${this.$route.params.id}`
            );
            console.log(this.profile)
            this.loading = false;
        },

        updateProfile(event) {
            this.$root.updateData(this.profile, `/api/user/userprofiles/${this.$route.params.id}`).then(response => {
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
        }
    }
}
</script>
