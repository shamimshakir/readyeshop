<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Unit" btnRoute="units" btnName="Units" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateUnit($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Unit Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !unit.unit_display
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="unit.unit_display" placeholder="unit Name" />
                            <p class="text-danger" v-if="
                                errors.unit_display.length > 0 && !unit.unit_display
                            " v-for="unit_display in errors.unit_display">
                                {{ unit_display }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !unit.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="unit.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !unit.status
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
            unit: {},
        }
    },
    created() {
        this.getUnit();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getUnit() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/units/${this.$route.params.id}`
            );
            this.unit = data[0];
            this.loading = false;
        },

        updateUnit(event) {
            this.$root.updateData(this.unit, `/api/user/units/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "units",
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
