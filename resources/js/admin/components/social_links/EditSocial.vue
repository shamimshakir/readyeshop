<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Social Link" btnRoute="social_links" btnName="Social Links" />
        <div class="card-body">
            <vue-loaders-line-scale-pulse-out v-if="loading" color="#3f51b5" />
            <form @submit.prevent="updatSocialLink($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Social Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !sLink.social_name
                            ? 'form-control border-danger'
                            : 'form-control' " v-model="sLink.social_name" placeholder="Social Name" />
                            <p class="text-danger" v-if="
                                errors.social_name.length > 0 && !sLink.social_name
                            " v-for="social_name in errors.social_name">
                                {{ social_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>URL <span class="text-danger">*</span></label>
                            <input type="text" :class="!isEmpty(errors) && !sLink.url  ? 'form-control border-danger' : 'form-control' " v-model="sLink.url" placeholder="URL">
                            <p class="text-danger" v-if="
                                errors.url.length > 0 && !sLink.url
                            " v-for="url in errors.url">
                                {{ url }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Icon <span class="text-danger">*</span></label>
                            <input type="text" :class="!isEmpty(errors) && !sLink.icon  ? 'form-control border-danger' : 'form-control' " v-model="sLink.icon" placeholder="Icon">
                            <p class="text-danger" v-if="
                                errors.icon.length > 0 && !sLink.icon
                            " v-for="icon in errors.icon">
                                {{ icon }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !sLink.active_status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="sLink.active_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.active_status.length > 0 && !sLink.active_status
                            " v-for="active_status in errors.active_status">
                                {{ active_status }}
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
            sLink: {},
            errors: [],
        }
    },
    created() {
        this.getSLink();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getSLink() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/social_link/${this.$route.params.id}`
            );
            this.sLink = data[0];
            console.log(this.sLink)
            this.loading = false;
        },
        updatSocialLink(event) {
            this.$root.updateData(this.sLink, `/api/user/social_link/${this.$route.params.id}`).then(response => {
                this.$alert(response.data.message);
                event.target.reset();
                this.$router.push({
                    name: "social_links"
                });
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                }
            })
        }
    }
}
</script>
