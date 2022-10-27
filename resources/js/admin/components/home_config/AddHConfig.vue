<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Config" btnRoute="home_configs" btnName="HomePage Config" />
        <div class="card-body">
            <form @submit.prevent="AddhConfig($event)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !hConfig.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="hConfig.name" placeholder="Name" />
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
                <button type="submit" class="btn btn-primary">Create hConfig</button>
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
            hConfig: {
                status: "",
            },
            errors: [],
        }
    },
    created() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        AddhConfig(event) {
            this.$root.addData(this.hConfig, '/api/user/homeconfigs').then(response => {
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
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
