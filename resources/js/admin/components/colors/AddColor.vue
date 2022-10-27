<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Color" btnRoute="colors" btnName="Colors" />
        <div class="card-body">
            <form @submit.prevent="addColor($event)">
                <div class="form-group">
                    <label>Color Name <span class="text-danger">*</span></label>
                    <input type="text" :class="
                            !isEmpty(errors) && !color.color_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="color.color_name" placeholder="Color Name" />
                    <p class="text-danger" v-if="
                                errors.color_name.length > 0 && !color.color_name
                            " v-for="color_name in errors.color_name">
                        {{ color_name }}
                    </p>
                </div>
                <div class="form-group">
                    <label>Other Language</label>
                    <input type="text" class="form-control" v-model="color.other_language" placeholder="Other Language">
                </div>
                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select :class="
                            !isEmpty(errors) && !color.color_status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="color.color_status">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    <p class="text-danger" v-if="
                                errors.color_status.length > 0 && !color.color_status
                            " v-for="color_status in errors.color_status">
                        {{ color_status }}
                    </p>
                </div>
                <button type="submit" class="btn btn-primary">Create Color</button>
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
            color: {
                color_status: "",
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
        addColor(event) {
            this.$root.addData(this.color, '/api/user/colors').then(response => {
                this.$alert(response.data.message);
                event.target.reset();
                this.$router.push({
                    name: "colors"
                });
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                }
            })
        },
    }
}
</script>
