<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add unit" btnRoute="units" btnName="units" />
        <div class="card-body">
            <form @submit.prevent="addunit($event)">
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
                <button type="submit" class="btn btn-primary">Create unit</button>
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
            unit: {
                status: "",
            },
            errors: [],
        }
    },
    created() {
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
  
        addunit(event) {
            this.$root.addData(this.unit, '/api/user/units').then(response => {
                console.dir(response)
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
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add Unit",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
