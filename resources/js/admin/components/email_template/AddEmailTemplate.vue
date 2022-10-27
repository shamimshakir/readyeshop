<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Template" btnRoute="email_templates" btnName="Email Template" />
        <div class="card-body">
            <form @submit.prevent="addemailTemplate($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Short Code <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !emailTemplate.short_code
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="emailTemplate.short_code" placeholder="Short Code" />
                            <p class="text-danger" v-if="
                                errors.short_code.length > 0 && !emailTemplate.short_code
                            " v-for="short_code in errors.short_code">
                                {{ short_code }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !emailTemplate.title
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="emailTemplate.title" placeholder="Title" />
                            <p class="text-danger" v-if="
                                errors.title.length > 0 && !emailTemplate.title
                            " v-for="title in errors.title">
                                {{ title }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" class="form-control" v-model="emailTemplate.subject" placeholder="Subject" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !emailTemplate.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="emailTemplate.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !emailTemplate.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Body <span class="text-danger">*</span></label>
                            <tinymce id="d1" :other_options="tinyOptions" v-model="emailTemplate.body"></tinymce>
                            <p class="text-danger" v-if="
                                errors.body.length > 0 && !emailTemplate.body
                            " v-for="body in errors.body">
                                {{ body }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create emailTemplate</button>
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
            emailTemplate: {
                status: "",
            },
            errors: [],
            tinyOptions: {
                'height': 200
            }
        }
    },
    created() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        addemailTemplate(event) {
            this.$root.addData(this.emailTemplate, '/api/user/emailtemplates').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "email_templates",
                });
                event.target.reset();
            }).catch(error => {
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
