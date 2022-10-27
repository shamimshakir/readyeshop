<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Page" btnRoute="page_contents" btnName="Page Contents" />
        <div class="card-body">
            <form @submit.prevent="AddpageContent($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Page Title <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !pageContent.page_title
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="pageContent.page_title" placeholder="Page Title" />
                            <p class="text-danger" v-if="
                                errors.page_title.length > 0 && !pageContent.page_title
                            " v-for="page_title in errors.page_title">
                                {{ page_title }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Page Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !pageContent.page_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="pageContent.page_name" placeholder="Page Name" />
                            <p class="text-danger" v-if="
                                errors.page_name.length > 0 && !pageContent.page_name
                            " v-for="page_name in errors.page_name">
                                {{ page_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !pageContent.active_status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="pageContent.active_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.active_status.length > 0 && !pageContent.active_status
                            " v-for="active_status in errors.active_status">
                                {{ active_status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Page Content</label>                            
                            <tinymce id="d1" :other_options="tinyOptions"  v-model="pageContent.page_content"></tinymce>
                             <p class="text-danger" v-if="
                                errors.page_content.length > 0 && !pageContent.page_content
                            " v-for="page_content in errors.page_content">
                                {{ page_content }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Page</button>
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
            pageContent: {
                active_status: "",
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

        AddpageContent(event) {
            this.$root.addData(this.pageContent, '/api/user/pagecontents').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "page_contents",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add pageContent",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
