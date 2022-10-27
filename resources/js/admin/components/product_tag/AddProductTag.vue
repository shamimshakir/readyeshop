<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add producttag" btnRoute="producttags" btnName="producttags" />
        <div class="card-body">
            <form @submit.prevent="addproducttag($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Tag Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !producttag.tag_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="producttag.tag_name" placeholder="product Tag Name" />
                            <p class="text-danger" v-if="
                                errors.tag_name.length > 0 && !producttag.tag_name
                            " v-for="tag_name in errors.tag_name">
                                {{ tag_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Product Tag Label <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !producttag.tag_label
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="producttag.tag_label" placeholder="Product Tag Label" />
                            <p class="text-danger" v-if="
                                errors.tag_label.length > 0 && !producttag.tag_label
                            " v-for="tag_label in errors.tag_label">
                                {{ tag_label }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Product Tag Details <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !producttag.location_detail
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="producttag.location_detail" placeholder="Product Tag Details" />
                            <p class="text-danger" v-if="
                                errors.location_detail.length > 0 && !producttag.location_detail
                            " v-for="location_detail in errors.location_detail">
                                {{ location_detail }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !producttag.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="producttag.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !producttag.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create product tag</button>
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
            producttag: {
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
  
        addproducttag(event) {
            this.$root.addData(this.producttag, '/api/user/producttags').then(response => {
                console.dir(response)
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "producttag",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add producttag",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
