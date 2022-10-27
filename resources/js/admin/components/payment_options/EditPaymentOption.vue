<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Payment Option" btnRoute="payment_options" btnName="Payment Options" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updatePaymentOption($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !paymentOption.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="paymentOption.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !paymentOption.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !paymentOption.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="paymentOption.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !paymentOption.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Pharm</label>
                            <textarea rows="7" :class="
                            !isEmpty(errors) && !paymentOption.pharm
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="paymentOption.pharm" placeholder="Pharm">
                    </textarea>
                            <p class="text-danger" v-if="
                                errors.pharm.length > 0 && !paymentOption.pharm
                            " v-for="pharm in errors.pharm">
                                {{ pharm }}
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
            paymentOption: {},
        }
    },
    created() {
        this.getPaymentOption();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        async getPaymentOption() {
            this.loading = true;
            let data = await this.$root.getAllData(
                `/api/user/paymentoptions/${this.$route.params.id}`
            );
            this.paymentOption = data[0];
            this.loading = false;
        },

        updatePaymentOption(event) {
            this.$root.updateData(this.paymentOption, `/api/user/paymentoptions/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "payment_options",
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
