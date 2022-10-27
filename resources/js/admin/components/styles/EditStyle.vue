<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Color CSS" btnRoute="styles" btnName="Styles" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateStyle($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Label <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !style.label
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="style.label" placeholder="Label" />
                            <p class="text-danger" v-if="
                                errors.label.length > 0 && !style.label
                            " v-for="label in errors.label">
                                {{ label }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Item / Selector Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !style.item
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="style.item" placeholder="Selector Name" />
                            <p class="text-danger" v-if="
                                errors.item.length > 0 && !style.item
                            " v-for="item in errors.item">
                                {{ item }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Value <span class="text-danger">*</span></label>
                            <input type="color" :class="
                            !isEmpty(errors) && !style.item_value
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="style.item_value" placeholder="Value" />
                            <p class="text-danger" v-if="
                                errors.item_value.length > 0 && !style.item_value
                            " v-for="item_value in errors.item_value">
                                {{ item_value }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !style.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="style.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !style.status
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
            style: {},
        }
    },
    created() {
        this.getStyle();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getStyle() {
            this.loading = true;
            this.style = await this.$root.getAllData(
                `/api/user/csses/${this.$route.params.id}`
            );
            this.loading = false;
        },

        updateStyle(event) {
            this.$root.updateData(this.style, `/api/user/csses/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "styles",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
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
