<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Status" btnRoute="ord_statuses" btnName="Order Status" />
        <div class="card-body">
            <form @submit.prevent="addOdStatus($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !odSts.ord_status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="odSts.ord_status" placeholder="Status Name" />
                            <p class="text-danger" v-if="
                                errors.ord_status.length > 0 && !odSts.ord_status
                            " v-for="ord_status in errors.ord_status">
                                {{ ord_status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Serial <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !odSts.sl
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="odSts.sl" placeholder="Serial" />
                            <p class="text-danger" v-if="
                                errors.sl.length > 0 && !odSts.sl
                            " v-for="sl in errors.sl">
                                {{ sl }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Icon <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !odSts.icon
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " v-model="odSts.icon" placeholder="Serial" />
                            <p class="text-danger" v-if="
                                errors.icon.length > 0 && !odSts.icon
                            " v-for="icon in errors.icon">
                                {{ icon }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                !isEmpty(errors) && !odSts.status
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="odSts.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !odSts.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Status</button>
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
            odSts: {
status: ""
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
        addOdStatus(event) {
            this.$root.addData(this.odSts, '/api/user/orderStatus').then(response => {
                this.$alert(response.data.message);
                event.target.reset();
                this.$router.push({
                    name: "ord_statuses"
                });
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                }
                console.dir(error)
            })
        },
    }
}
</script>
