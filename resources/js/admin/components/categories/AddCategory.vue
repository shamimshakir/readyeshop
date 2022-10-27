<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add Category" btnRoute="categories" btnName="Categories" />
        <div class="card-body">
            <form @submit.prevent="addCategory($event)">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cat_name">Category Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="categoryInputs.cat_name" :class=" 
                                !isEmpty(errors) && !categoryInputs.cat_name
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                " placeholder="Category Name" />
                            <p class="text-danger" v-if="errors.cat_name.length > 0 && !categoryInputs.cat_name" v-for="cat_name in errors.cat_name"> {{ cat_name }} </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cat_name_others">Other Language Name</label>
                            <input type="text" class="form-control" v-model="categoryInputs.cat_name_others" placeholder="Other Language Name">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="catagory_code">Category Code</label>
                            <input type="text" class="form-control" v-model="categoryInputs.catagory_code" placeholder="Category Code">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cat_name">Level <span class="text-danger">*</span></label>
                            <select name="level_id" v-model="categoryInputs.level_id" @change="getLavelCats($event)" :class=" 
                                !isEmpty(errors) && !categoryInputs.level_id
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                ">
                                <option value="">Select a Level</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                            <p class="text-danger" v-if="errors.level_id.length > 0 && !categoryInputs.level_id" v-for="level_id in errors.level_id"> {{ level_id }} </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="cat_parent_id">Parent </label>
                            <select name="cat_parent_id" v-model="categoryInputs.cat_parent_id" class="form-control">
                                <option value="0">Select Parent category</option>
                                <option v-for="parentCat in parent_categories" :value="parentCat.id" :key="parentCat.id">
                                    {{ parentCat.cat_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="act_status">Status <span class="text-danger">*</span></label>
                            <select v-model="categoryInputs.act_status" :class=" 
                                !isEmpty(errors) && !categoryInputs.act_status
                                    ? 'form-control border-danger'
                                    : 'form-control'
                                ">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inctive</option>
                            </select>
                            <p class="text-danger" v-if="errors.act_status.length > 0 && !categoryInputs.act_status" v-for="act_status in errors.act_status"> {{ act_status }} </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input-tag placeholder="Meta Keywords" v-model="meta_keywords" class="form-control"></input-tag>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" v-model="categoryInputs.meta_description" placeholder="Meta Descriptions"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Category</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import InputTag from 'vue-input-tag'
export default {
    components: {
        'input-tag': InputTag,
        CardHeader,
    },
    data() {
        return {
            meta_keywords: [],
            categoryInputs: {
                level_id: "",
                cat_parent_id: "0",
                act_status: "",
            },
            countries: [],
            errors: [],
            parent_categories: [],
        };
    },
    created() {},
    mounted() {},
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        getLavelCats(event) {
            let id = event.target.value;
            id--;
            this.$root.getAllData(
                `/api/user/categories/showByLevel/${id}`
            ).then(res => {
                this.parent_categories = res;
            });
        },
        addCategory(event) {
            this.categoryInputs.meta_keyword = this.meta_keywords.join(',');
            this.$root.addData(this.categoryInputs, '/api/user/categories').then(response => {
                console.dir(response);
                this.$alert(response.data.message);
                event.target.reset();
                this.$router.push({
                    name: "categories"
                });
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                }
            })
        },
    },
};
</script>
