<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Shipper" btnRoute="shippers" btnName="Shippers" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateShipper($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Shipper Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !shipper.sp_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="shipper.sp_name" placeholder="Shipper Name" />
                            <p class="text-danger" v-if="
                                errors.sp_name.length > 0 && !shipper.sp_name
                            " v-for="sp_name in errors.sp_name">
                                {{ sp_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !shipper.sp_mobile
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="shipper.sp_mobile" placeholder="Phone" />
                            <p class="text-danger" v-if="
                                errors.sp_mobile.length > 0 && !shipper.sp_mobile
                            " v-for="sp_mobile in errors.sp_mobile">
                                {{ sp_mobile }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !shipper.sp_email
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="shipper.sp_email" placeholder="Email" />
                            <p class="text-danger" v-if="
                                errors.sp_email.length > 0 && !shipper.sp_email
                            " v-for="sp_email in errors.sp_email">
                                {{ sp_email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Contact Person </label>
                            <input type="text" class="form-control" v-model="shipper.sp_contact_person" placeholder="Contact Person" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Company Name </label>
                            <input type="text" class="form-control" v-model="shipper.sp_company" placeholder="Company Name" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !shipper.status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="shipper.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !shipper.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea type="text" :class="
                                !isEmpty(errors) && !shipper.sp_sddress
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="shipper.sp_sddress" placeholder="Address"></textarea>
                            <p class="text-danger" v-if="
                                errors.sp_sddress.length > 0 && !shipper.sp_sddress
                            " v-for="sp_sddress in errors.sp_sddress">
                                {{ sp_sddress }}
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
            shipper: {},
        }
    },
    created() {
        this.getShipper();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getShipper() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/shippers/${this.$route.params.id}`
            );
            this.shipper = data[0];
            this.loading = false;
        },

        updateShipper(event) {
            this.$root.updateData(this.shipper, `/api/user/shippers/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "shippers",
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
