<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Email Setup" btnRoute="email_setups" btnName="Email Setups" />
        <div class="card-body">
            <form @submit.prevent="addemailSetup($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !emailSetup.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="emailSetup.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !emailSetup.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Port</label>
                            <input type="text" class="form-control" v-model="emailSetup.port" placeholder="Port" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Username </label>
                            <input type="text" class="form-control" v-model="emailSetup.Username" placeholder="Username" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" v-model="emailSetup.Password" placeholder="Password" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>setFrom </label>
                            <input type="text" class="form-control" v-model="emailSetup.setFrom" placeholder="setFrom" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>SMTPAuth </label>
                            <input type="text" class="form-control" v-model="emailSetup.SMTPAuth" placeholder="SMTPAuth" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Host </label>
                            <input type="text" class="form-control" v-model="emailSetup.Host" placeholder="Host" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>SMTPSecure</label>
                            <input type="text" class="form-control" v-model="emailSetup.SMTPSecure" placeholder="SMTPSecure" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>addReplyTo </label>
                            <input type="text" class="form-control" v-model="emailSetup.addReplyTo" placeholder="addReplyTo" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>addCC </label>
                            <input type="text" class="form-control" v-model="emailSetup.addCC" placeholder="addCC" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>addBCC </label>
                            <input type="text" class="form-control" v-model="emailSetup.addBCC" placeholder="addBCC" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>isHTML </label>
                            <input type="text" class="form-control" v-model="emailSetup.isHTML" placeholder="isHTML" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Mailer </label>
                            <input type="text" class="form-control" v-model="emailSetup.Mailer" placeholder="Mailer" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Send Email </label>
                            <input type="text" class="form-control" v-model="emailSetup.send_email" placeholder="Send Email" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Receive Email </label>
                            <input type="text" class="form-control" v-model="emailSetup.receive_email" placeholder="Receive Email" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !emailSetup.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="emailSetup.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !emailSetup.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create emailSetup</button>
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
            emailSetup: {
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
  
        addemailSetup(event) {
            this.$root.addData(this.emailSetup, '/api/user/emailsetups').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "email_setups",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add Setup",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
