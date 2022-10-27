<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Allocation" btnRoute="sms_allocations" btnName="SMS Allocation" />
        <div class="card-body">
            <form @submit.prevent="Addsmsallo($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !smsallo.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="smsallo.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !smsallo.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Amount <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !smsallo.allocate_ammount
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="smsallo.allocate_ammount" placeholder="smsallo Name" />
                            <p class="text-danger" v-if="
                                errors.allocate_ammount.length > 0 && !smsallo.allocate_ammount
                            " v-for="allocate_ammount in errors.allocate_ammount">
                                {{ allocate_ammount }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create smsallo</button>
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
            smsallo: {
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

        Addsmsallo(event) {
            this.$root.addData(this.smsallo, '/api/user/smsallocations').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "sms_allocations",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add smsallo",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
