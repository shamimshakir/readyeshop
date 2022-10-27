<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add News" btnRoute="news" btnName="News" />
        <div class="card-body">
            <form @submit.prevent="AddNews($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Title <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            checkError('news_title')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="sNews.news_title" placeholder="Title" />
                            <p class="text-danger" v-if="checkError('news_title')" v-for="news_title in errors.news_title">
                                {{ news_title }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>News Header <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            checkError('news_header')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="sNews.news_header" placeholder="Title" />
                            <p class="text-danger" v-if="checkError('news_header')" v-for="news_header in errors.news_header">
                                {{ news_header }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Details <span class="text-danger">*</span></label>
                            <tinymce id="d1" :other_options="tinyOptions"  v-model="sNews.news_detail"></tinymce>
                            <p class="text-danger" v-if="checkError('news_detail')" v-for="news_detail in errors.news_detail">
                                {{ news_detail }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Image <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleImage" />
                            <p class="text-danger" v-if="checkError('news_image')" v-for="news_image in errors.news_image">
                                {{ news_image }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                                checkError('news_status')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="sNews.news_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="checkError('news_status')" v-for="news_status in errors.news_status">
                                {{ news_status }}
                            </p>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create News</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import UploadImages from "vue-upload-drop-images";

export default {
    components: {
        CardHeader,        
        UploadImages,
    },
    data() {
        return {
            sNews: {
                news_status: "",
            },
            newsImageInput: null,
            errors: [],
            tinyOptions: {
                'height': 200
            }
        }
    },
    created() {},
    methods: {
        handleImage(files) {
            this.newsImageInput = files[0];
        },
        checkError(field) {
            if (!this.isEmpty(this.errors)) {
                if (field in this.errors) {
                    return true
                }
            }
            return false;
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        AddNews(event) {
            var form = new FormData();
            form.append("news_title", this.sNews.news_title);
            form.append("news_header", this.sNews.news_header);
            form.append("news_detail", this.sNews.news_detail);
            form.append("news_status", this.sNews.news_status);
            form.append("news_image", this.newsImageInput);

            this.axios
                .post(`${this.$store.state.hostBase}/api/user/news`, form, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.$fire({
                        title: response.data.message,
                        type: "success",
                        timer: 2000
                    });
                    this.$router.push({
                        name: "news",
                    });
                    event.target.reset();
                })
                .catch((error) => {
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to Add News",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    }
}
</script>
