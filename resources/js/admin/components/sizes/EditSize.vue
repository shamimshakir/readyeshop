<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Size" btnRoute="sizes" btnName="Sizes" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateSize($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Size Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !size.size_display
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="size.size_display" placeholder="Size Name" />
                            <p class="text-danger" v-if="
                                errors.size_display.length > 0 && !size.size_display
                            " v-for="size_display in errors.size_display">
                                {{ size_display }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Size Type </label>
                            <input type="text" class="form-control" v-model="size.size_type" placeholder="Size Type" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !size.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="size.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !size.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Size Remarks </label>
                            <textarea type="text" class="form-control" v-model="size.size_remarks" placeholder="Size Remarks"></textarea>
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
            size: {},
        }
    },
    created() {
        this.getSize();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getSize() {
            this.loading = true;
            this.size = await this.$root.getAllData(
                `/api/user/sizes/${this.$route.params.id}`
            );
            this.loading = false;
        },

        updateSize(event) {
            this.$root.updateData(this.size, `/api/user/sizes/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "sizes",
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
