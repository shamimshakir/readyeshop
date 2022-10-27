<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add FAQ" btnRoute="faqs" btnName="FAQs" />
        <div class="card-body">
            <form @submit.prevent="addFaq($event)">
                <div class="form-group">
                    <label>FAQ Question <span class="text-danger">*</span></label>
                    <input type="text" :class="
                            !isEmpty(errors) && !faq.faq_question
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="faq.faq_question" placeholder="FAQ Question" />
                    <p class="text-danger" v-if="
                                errors.faq_question.length > 0 && !faq.faq_question
                            " v-for="faq_question in errors.faq_question">
                        {{ faq_question }}
                    </p>
                </div>
                <div class="form-group">
                    <label>FAQ Answer</label>
                    
                    <tinymce id="d1" :other_options="tinyOptions"  v-model="faq.faq_answer"></tinymce>
                </div>
                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select :class="
                            !isEmpty(errors) && !faq.active_status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="faq.active_status">
                        <option value="">Select Status</option>
                        <option value="1">Active</option>
                        <option value="2">Inactive</option>
                    </select>
                    <p class="text-danger" v-if="
                                errors.active_status.length > 0 && !faq.active_status
                            " v-for="active_status in errors.active_status">
                        {{ active_status }}
                    </p>
                </div>
                <button type="submit" class="btn btn-primary">Create FAQ</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import {
    VueEditor,
    Quill
} from "vue2-editor";
export default {
    components: {
        CardHeader,
        VueEditor,
        Quill,
    },
    data() {
        return {
            faq: {
                active_status: "",
            },
            errors: [],
            tinyOptions: {
                'height': 200
            }
        }
    },
    created() {

    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        addFaq(event) {
            this.$root.addData(this.faq, '/api/user/faqs').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "faqs",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add FAQ",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
