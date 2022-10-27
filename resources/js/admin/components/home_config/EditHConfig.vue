<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Config" btnRoute="home_configs" btnName="HomePage Config" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateHConfig($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !hConfig.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="hConfig.name" placeholder="Name" readonly />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !hConfig.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !hConfig.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="hConfig.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !hConfig.status
                            " v-for="status in errors.status">
                                {{ status }}
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
            hConfig: {},
        }
    },
    created() {
        this.getHConfig();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getHConfig() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/homeconfigs/${this.$route.params.id}`
            );
            this.hConfig = data[0];
            this.loading = false;
        },

        updateHConfig(event) {
            this.$root.updateData(this.hConfig, `/api/user/homeconfigs/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "home_configs",
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
