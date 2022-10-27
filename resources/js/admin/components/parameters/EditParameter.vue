<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit parameter" btnRoute="parameters" btnName="parameters" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateParameter($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Parameter Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !parameter.parameter_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="parameter.parameter_name" placeholder="Parameter Name" />
                            <p class="text-danger" v-if="
                                errors.parameter_name.length > 0 && !parameter.parameter_name
                            " v-for="parameter_name in errors.parameter_name">
                                {{ parameter_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Parameter Value <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !parameter.parameter_value
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="parameter.parameter_value">
                                <option value="ON">ON</option>
                                <option value="OFF">OFF</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.parameter_value.length > 0 && !parameter.parameter_value
                            " v-for="status in errors.parameter_value">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !parameter.parameter_status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="parameter.parameter_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.parameter_status.length > 0 && !parameter.parameter_status
                            " v-for="status in errors.parameter_status">
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
            parameter: {},
        }
    },
    created() {
        this.getParameter();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getParameter() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/parameters/${this.$route.params.id}`
            );
            this.parameter = data[0];
            this.loading = false;
        },

        updateParameter(event) {
            this.$root.updateData(this.parameter, `/api/user/parameters/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "parameters",
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
