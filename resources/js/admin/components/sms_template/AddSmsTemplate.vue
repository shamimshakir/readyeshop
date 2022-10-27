<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add SMS Template" btnRoute="sms_templates" btnName="SMS Templates" />
        <div class="card-body">
            <form @submit.prevent="addSMSTemplate($event)">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>For <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !template.command
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="template.command" placeholder="For" />
                            <p class="text-danger" v-if="
                                errors.command.length > 0 && !template.command
                            " v-for="command in errors.command">
                                {{ command }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>SMS Body <span class="text-danger">*</span></label>
                            <p class="mt-0 mb-0" v-pre>Body- Keyword: <span>{{clients_name}}</span> , <span>{{update_date}}</span> , <span>{{amount}}</span> , <span>{{order_id}}</span>
                            </p>
                            <textarea type="text" :class="
                            !isEmpty(errors) && !template.description
                                ? 'form-control border-danger'
                                : 'form-control'
                            " 
                            v-model="template.description" placeholder="SMS Body"></textarea>
                            <p class="text-danger" v-if="
                                errors.description.length > 0 && !template.description
                            " v-for="description in errors.description">
                                {{ description }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Type <span class="text-danger">*</span></label>
                            <select class='form-control' v-model="template.type">
                                <option value="">Select Type</option>
                                <option value="1">System</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !template.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="template.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !template.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Template</button>
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
            template: {
                status: "",
                type: "",
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
  
        addSMSTemplate(event) {
            this.$root.addData(this.template, '/api/user/smstemplates').then(response => {
                console.dir(response)
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "sms_templates",
                });
                event.target.reset();
            }).catch(error => {
                console.dir(error)
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add Template",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
