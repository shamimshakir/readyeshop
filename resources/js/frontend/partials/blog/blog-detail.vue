<template>
<div>
    <Header />
    <Breadcrumbs title="Blog Details" />
    <section class="blog-detail-page section-b-space ratio2_3">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 blog-detail">
                    <img :src="imageSrc + blogDetails.news_image" alt="blog" class="img-fluid">
                    <h3>{{ blogDetails.news_header }}</h3>
                    <ul class="post-social">
                        <li>{{ new Date(blogDetails.created_at).toLocaleDateString() }}</li>
                        <li>Posted By : Admin</li>
                        <li><i class="fa fa-heart"></i> 5 Hits
                        </li>
                        <li><i class="fa fa-comments"></i> 10 Comment
                        </li>
                    </ul>
                    <div v-html="blogDetails.news_detail"></div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</div>
</template>

<script>
import Breadcrumbs from '../../components/widgets/breadcrumbs'
import Header from "../../components/header/header1";
import Footer from "../../components/footer/footer1";
export default {
    components: {
        Breadcrumbs,
        Header,
		Footer,
    },
    data() {
        return {
            blogDetails: {},
            imageSrc: "",
        }
    },
    computed: {
        blogId() {
            return this.$route.params.blogId;
        },
    },
    created() {
        this.getBlogDetails();
    },
    methods: {
        async getBlogDetails() {
            let dataObj = {
                id: this.$route.params.blogId
            };
            let data = await this.$root.getDetailsData(dataObj, `/api/news_param`);
            this.imageSrc = data.data.url;
            this.blogDetails = data.data.data[0];
        },
    }
}
</script>
