<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add metaTag" btnRoute="meta_tags" btnName="Meta Tags" />
        <div class="card-body">
            <form @submit.prevent="AddmetaTag($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Meta Page <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !metaTag.meta_page
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="metaTag.meta_page" placeholder="Meta Page" />
                            <p class="text-danger" v-if="
                                errors.meta_page.length > 0 && !metaTag.meta_page
                            " v-for="meta_page in errors.meta_page">
                                {{ meta_page }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !metaTag.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="metaTag.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !metaTag.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Meta Key <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !metaTag.meta_type
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="metaTag.meta_type" placeholder="Meta Key" />
                            <p class="text-danger" v-if="
                                errors.meta_type.length > 0 && !metaTag.meta_type
                            " v-for="meta_type in errors.meta_type">
                                {{ meta_type }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Meta Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !metaTag.meta_name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="metaTag.meta_name" placeholder="Meta Name" />
                            <p class="text-danger" v-if="
                                errors.meta_name.length > 0 && !metaTag.meta_name
                            " v-for="meta_name in errors.meta_name">
                                {{ meta_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Meta Content <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !metaTag.meta_content
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="metaTag.meta_content" placeholder="Meta Content" />
                            <p class="text-danger" v-if="
                                errors.meta_content.length > 0 && !metaTag.meta_content
                            " v-for="meta_content in errors.meta_content">
                                {{ meta_content }}
                            </p>
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Create Meta Tag</button>
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
            metaTag: {
                status: "",
            },
            errors: [],
        }
    },
    created() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },

        AddmetaTag(event) {
            this.$root.addData(this.metaTag, '/api/user/metatags').then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "meta_tags",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add metaTag",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
