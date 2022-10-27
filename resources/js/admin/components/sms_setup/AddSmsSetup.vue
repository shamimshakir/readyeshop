<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add setup" btnRoute="setups" btnName="setups" />
        <div class="card-body">
            <form @submit.prevent="addSetup($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !setup.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !setup.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>URL <span class="text-danger">*</span></label>
                            <input type="text" :class="
                                !isEmpty(errors) && !setup.sms_url
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="setup.sms_url" placeholder="URL" />
                            <p class="text-danger" v-if="
                                errors.sms_url.length > 0 && !setup.sms_url
                            " v-for="sms_url in errors.sms_url">
                                {{ sms_url }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label v-pre>{{SMS Param: SMS Param (username =your user name, password=your password, receiver = {{mobile}},message = {{smsbody} Others parameters add like this ) Do not change {{mobile}},{{smsbody}} }}<span class="text-danger">*</span></label>
                            <textarea type="text" :class="
                                !isEmpty(errors) && !setup.submit_param
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="setup.submit_param" placeholder="SMS Param"></textarea>
                            <p class="text-danger" v-if="
                                errors.submit_param.length > 0 && !setup.submit_param
                            " v-for="submit_param in errors.submit_param">
                                {{ submit_param }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Type <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !setup.type
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.type">
                                <option value="">Select Type</option>
                                <option value="get">get</option>
                                <option value="post">post</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.type.length > 0 && !setup.type
                            " v-for="type in errors.type">
                                {{ type }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !setup.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="setup.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !setup.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create setup</button>
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
        }
    },
    created() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        addSetup(event) {
            this.$root.addData(this.setup, '/api/user/smssetups').then(response => {
                console.dir(response)
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "sms_setups",
                });
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
    }
}
</script>
