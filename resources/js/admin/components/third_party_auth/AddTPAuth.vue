<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add tpauth" btnRoute="third_party_auths" btnName="tpauths" />
        <div class="card-body">
            <form @submit.prevent="Addtpauth($event)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>App ID <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !tpauth.app_id
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.app_id" placeholder="App ID" />
                            <p class="text-danger" v-if="
                                errors.app_id.length > 0 && !tpauth.app_id
                            " v-for="app_id in errors.app_id">
                                {{ app_id }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>App Secret <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !tpauth.app_secret
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.app_secret" placeholder="App Secret" />
                            <p class="text-danger" v-if="
                                errors.app_secret.length > 0 && !tpauth.app_secret
                            " v-for="app_secret in errors.app_secret">
                                {{ app_secret }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Default Graph Version <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !tpauth.default_graph_version
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.default_graph_version" placeholder="Default Graph Version" />
                            <p class="text-danger" v-if="
                                errors.default_graph_version.length > 0 && !tpauth.default_graph_version
                            " v-for="default_graph_version in errors.default_graph_version">
                                {{ default_graph_version }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !tpauth.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !tpauth.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>URL <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !tpauth.url
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.url" placeholder="URL" />
                            <p class="text-danger" v-if="
                                errors.url.length > 0 && !tpauth.url
                            " v-for="url in errors.url">
                                {{ url }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !tpauth.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="tpauth.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.tpauth.length > 0 && !tpauth.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create App</button>
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
            tpauth: {},
            errors: [],
        }
    },
    created() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        Addtpauth(event) {
            this.$root.addData(this.tpauth, '/api/user/thirdpartyauths').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "third_party_auths",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add tpauth",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
