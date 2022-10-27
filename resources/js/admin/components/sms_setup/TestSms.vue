<template>
<div class="col-lg-6">
    <div class="card m-b-30 mt-5">
        <CardHeader
                title="SMS Test"
                btnRoute=""
                btnName=""
                :menu_name="smstests"
            />
        <div class="card-body">
            <form @submit.prevent="addSetup($event)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Mobile No (01711111111) <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !setup.mobile
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.mobile" placeholder="Mobile No" />
                            <p class="text-danger" v-if="
                                errors.mobile.length > 0 && !setup.mobile
                            " v-for="mobile in errors.mobile">
                                {{ mobile }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label v-pre>SMS body<span class="text-danger">*</span></label>
                            <textarea type="text" :class="
                                !isEmpty(errors) && !setup.smsbody
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="setup.smsbody" placeholder="SMS Param"></textarea>
                            <p class="text-danger" v-if="
                                errors.smsbody.length > 0 && !setup.smsbody
                            " v-for="smsbody in errors.smsbody">
                                {{ smsbody }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>SMS <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !setup.sms_id
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.sms_id">
                                <option disabled value="">Select SMS</option>
                                <option v-for="smssetup in smssetups" :value="smssetup.id" :key="smssetup.id">
                                    {{ smssetup.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.sms_id.length > 0 && !setup.sms_id
                            " v-for="sms_id in errors.sms_id">
                                {{ sms_id }}
                            </p>
                        </div>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
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
            setup: {
                status: "",
                type: ""
            },
            errors: [],
            smssetups: [],
        }
    },
    created() {
        this.getSmsSetups();
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        addSetup(event) {
            this.$root.addData(this.setup, '/api/user/testsms').then(response => {
                console.dir(response)
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                // this.$router.push({
                //     name: "smstests",
                // });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add setup",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
        async getSmsSetups() {
                this.loading = true;
                this.smssetups = await this.$root.getAllData('/api/user/smssetups');
                this.loading = false;
            },
    }
}
</script>
