<template>
<div class="col-lg-6">
    <div class="card m-b-30 mt-5">
        <CardHeader
                title="Email Test"
                btnRoute=""
                btnName=""
                :menu_name="emailtests"
            />
        <div class="card-body">
            <form @submit.prevent="addSetup($event)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !setup.clientemailaddress
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.clientemailaddress" placeholder="Email" />
                            <p class="text-danger" v-if="
                                errors.clientemailaddress.length > 0 && !setup.clientemailaddress
                            " v-for="clientemailaddress in errors.clientemailaddress">
                                {{ clientemailaddress }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Subject <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !setup.subject
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.subject" placeholder="Subject" />
                            <p class="text-danger" v-if="
                                errors.subject.length > 0 && !setup.subject
                            " v-for="subject in errors.subject">
                                {{ subject }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label v-pre>Email body<span class="text-danger">*</span></label>
                            <textarea type="text" :class="
                                !isEmpty(errors) && !setup.body
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="setup.body" placeholder="Email body"></textarea>
                            <p class="text-danger" v-if="
                                errors.smsbody.length > 0 && !setup.body
                            " v-for="body in errors.body">
                                {{ body }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !setup.email_id
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.email_id">
                                <option disabled value="">Select Email</option>
                                <option v-for="smssetup in smssetups" :value="smssetup.id" :key="smssetup.id">
                                    {{ smssetup.name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.email_id.length > 0 && !setup.email_id
                            " v-for="email_id in errors.email_id">
                                {{ email_id }}
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
            this.$root.addData(this.setup, '/api/user/testemail').then(response => {
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
                this.smssetups = await this.$root.getAllData('/api/user/emailsetups');
                this.loading = false;
            },
    }
}
</script>
