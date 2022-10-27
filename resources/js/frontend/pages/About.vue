<template>
<div>
    <Header />
    <Breadcrumbs title="About" />
    <!-- about section start -->
    <section class="about-page section-b-space">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-section">
                        <img :src="imageSrc+getDetail.au_image" class="img-fluid" alt />
                    </div>
                </div>
                <div class="col-sm-12">
                    <div v-html="getDetail.short_description"></div>
                    <div v-html="getDetail.au_description"></div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</div>
</template>

<script>
import Breadcrumbs from '../components/widgets/breadcrumbs'
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
export default {
    components: {
        Header,
		Footer,
        Breadcrumbs,
    },
    data() {
        return {
            getDetail: {},
            imageSrc: "",
            meta: {},
        };
    },
    created() {
        this.getAboutUsDetail();
        this.getMeta();
    },
    methods: {
        async getAboutUsDetail() {
            let dataObj = {};
            let aboutData = await this.$root.getFrontData(dataObj, `/api/aboutUs`);
            this.getDetail = aboutData.data.data[0];
            this.imageSrc = aboutData.data.url;
        },
        async getMeta() {
            let dataObj = {
                'meta_page': 'about',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
        },
    },
    mounted() {},
    metaInfo() {
        return {            
            title:  this.meta.meta_name, 
            meta: [
                { name: 'description', content:  this.meta.meta_content},
                { name: 'keywords', content:  this.meta.meta_type},
                { property: 'og:title', content: this.meta.meta_content},
                { property: 'og:site_name', content: this.meta.meta_name},
                {property: 'og:type', content: 'website'},    
                {name: 'robots', content: 'index,follow'} 
            ]
        }
    }
};
</script>
