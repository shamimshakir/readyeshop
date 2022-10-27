<template>
    <div v-if="checkAvailability">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="title1 section-t-space">
                        <h4>{{ subtitle }}</h4>
                        <h2 class="title-inner1">{{ title }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <section class="blog p-t-0 pb-5 ratio2_3">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div v-swiper:mySwiper="swiperOption">
                            <div class="swiper-wrapper">
                                <div
                                    class="swiper-slide"
                                    v-for="(blog, index) in bloglist"
                                    :key="index"
                                >
                                    <router-link
                                        :to="{ name: 'blogdetails', params: { blogId: blog.id } }"
                                    >
                                        <div class="classic-effect">
                                            <div>
                                                <img
                                                    style="width: 100%; max-height: 230px;"
                                                    :src="imageSrc + blog.news_image"
                                                    class="img-fluid"
                                                    alt
                                                />
                                            </div>
                                            <span></span>
                                        </div>
                                    </router-link>
                                    <div class="blog-details">
                                        <h4>{{ published__date(blog.created_at) }}</h4>
                                        <router-link
                                            :to="{ name: 'blogdetails', params: { blogId: blog.id } }"
                                        >
                                            <p>{{ blog.news_title }}</p>
                                        </router-link>
                                        <hr class="style1" />
                                        <h6>by: Nextech , 2 Comment</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: 'from the blog',
            imageSrc: "",
            bloglist: [],
            subtitle: 'recent story',
            checkAvailability: 0,
            swiperOption: {
                slidesPerView: 3,
                spaceBetween: 20,
                freeMode: true,
                breakpoints: {
                    1199: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    420: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    }
                }
            }
        }
    },
    computed: {

    },
    created() {
        this.getBlogs();
    },
    methods: {
        published__date(date) {
            var d = new Date(date);
            var n = d.getDate();
            var month = d.toLocaleString('default', { month: 'short' });
            var year = d.getFullYear();

            return `${month} ${n}, ${year}`;
        },
        async getBlogs() {
            let dataObj = {
                'news_status': '1'
            };
            let blogData = await this.$root.getFrontData(dataObj, '/api/news_param');
            this.bloglist = blogData.data.data;
            this.checkAvailability = blogData.data.count;
            this.imageSrc = blogData.data.url;
        },
    }
}
</script>
