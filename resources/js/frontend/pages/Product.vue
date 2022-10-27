<template>
<div>
    <Header />
    <Breadcrumbs :title="getDetail.pd_name" />
    <section class="section-b-space">
        <div class="collection-wrapper">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#000" />
            <div class="container" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-3">
                        <productSidebar v-if="getDetail.category_id" :category="getDetail.category_id" />
                    </div>
                    <div class="col-lg-9 col-sm-12 col-xs-12 productdetail">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div v-swiper:mySwiper="swiperOption" ref="mySwiper">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <image-zoom :regular="imageSrc + getDetail.pd_thumbnail"
                                                    img-class="img-fluid" alt="Sky">
                                                </image-zoom>
                                            </div>
                                            <div class="swiper-slide" v-for="(pro__img,index) in getDetail.productimages" :key="index + 1">
                                                <image-zoom :regular="imageSrc + pro__img.pro_img_name"
                                                    img-class="img-fluid" alt="Sky">
                                                </image-zoom>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 slider-nav-images">
                                            <div v-swiper:mySwiper1="swiperOption1">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <img :src="imageSrc + getDetail.pd_thumbnail" id="pd_thumbnail" class="img-fluid bg-img" @click="slideTo(0)" />
                                                    </div>
                                                    <div class="swiper-slide" v-for="(pro__img,index) in getDetail.productimages" :key="index + 1">
                                                        <img :src="imageSrc + pro__img.pro_img_name" :id="pro__img.id" class="img-fluid bg-img" @click="slideTo(index + 1)" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 rtl-text">
                                    <div class="product-right">
                                        <h2>{{ getDetail.pd_name }}</h2>
                                        <h4 v-if="getDetail.onsale_stat">
                                            <del>{{ currency + getDetail.pd_prev_price }}</del>
                                            <span> 10% off</span>
                                        </h4>
                                        <h3 v-if="getDetail.onsale_stat">{{ currency + getDetail.pd_price }}</h3>
                                        <h3 v-else>{{ currency + getDetail.pd_prev_price }}</h3>
                                        <ul class="color-variant">
                                            <li v-for="(variant,variantIndex) in getDetail.productcolors" :key="variantIndex" :class="{ active: activeColor == variant.id }" @click="activeColor = variant.id">
                                                <a :class="[variant.color.color_name]" v-bind:style="{ 'background-color' : variant.color.color_name}"></a>
                                            </li>
                                        </ul>
                                        <div class="pro_inventory" v-if="getDetail.pd_qty <= 10">
                                            <p class="active"> Hurry! We have only {{ getDetail.pd_qty }} product in stock. </p>
                                            <div class="inventory-scroll">
                                                <span :style="{ width: getDetail.pd_qty * 100 / 10 + '%' }"></span>
                                            </div>
                                        </div>
                                        <div class="product-description border-product">
                                            <h6 class="product-title size-text" v-if="getDetail.size_apply==1">
                                                select size
                                            </h6>
                                            <div class="size-box">
                                                <ul>
                                                    <li class="product-title" v-for="(size,index) in getDetail.productsizes" :key="index" v-bind:class="{ active: selectedSize == size.id}" @click="selectedSize = size.id">
                                                        <a href="javascript:void(0)">{{size.size.size_display}}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <h5 class="avalibility" v-if="counter <= getDetail.pd_qty">
                                                <span>In Stock</span>
                                            </h5>
                                            <h5 class="avalibility" v-if="counter > getDetail.pd_qty">
                                                <span>Out of Stock</span>
                                            </h5>
                                            <h6 class="product-title">quantity</h6>
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn quantity-left-minus" data-type="minus" data-field @click="decrement()">
                                                            <i class="ti-angle-left"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity" class="form-control input-number" :disabled="counter > getDetail.stock" v-model="counter" />
                                                    <span class="input-group-prepend">
                                                        <button type="button" class="btn quantity-right-plus" data-type="plus" data-field @click="increment()">
                                                            <i class="ti-angle-right"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-buttons">
                                            <a href="javascript:void(0)" @click="addItemToCart(getDetail.id)" title="Add to cart">
                                                <button class="btn btn-solid" title="Add to cart">Add To Cart</button>
                                            </a>
                                            <button class="btn btn-solid" title="buy now" @click="buyNow(getDetail.id)" :disabled="counter > getDetail.stock">Buy Now</button>
                                        </div>
                                        <div class="border-product" v-if="getDetail.product_highlight!=''">
                                            <h6 class="product-title">Product Highlight</h6>
                                            <p v-html="getDetail.product_highlight"></p>
                                        </div>
                                        <div class="border-product">
                                            <h6 class="product-title">share it</h6>
                                            <div class="product-icon">
                                                <ul class="product-social">
                                                    
                                                    <li v-for="network in networks">
                                                        <ShareNetwork :network="network.network" :key="network.network" :url="sharing.url" :title="sharing.title" :description="sharing.description" :quote="sharing.quote" :hashtags="sharing.hashtags" :twitterUser="sharing.twitterUser" :media="sharing.media">
                                                            <i :class="network.icon"></i>
                                                        </ShareNetwork>
                                                    </li>
                                                </ul>
                                                <button class="wishlist-btn" @click="addToWishlist(getDetail.id)">
                                                    <i class="fa fa-heart"></i>
                                                    <span class="title-font">Add To WishList</span>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- <div class="border-product">
                                            <h6 class="product-title">Time Reminder</h6>
                                            <Timer date="December 20, 2021" />
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="tab-product m-0">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <b-tabs card> 
                                        <b-tab title="Details"  active>
                                            <b-card-text v-if="getDetail.product_detail != null" v-html="getDetail.product_detail">
                                            </b-card-text>
                                        </b-tab>
                                        <b-tab title="Specification" >
                                            <b-card-text v-if="getDetail.product_specification != null" v-html="getDetail.product_specification">
                                            </b-card-text>
                                        </b-tab>
                                        <b-tab title="Warranty" >
                                            <b-card-text v-if="getDetail.product_warranty != null" v-html="getDetail.product_warranty"></b-card-text>
                                        </b-tab>
                                        <b-tab title="Video">
                                            <b-card-text>
                                                <div class="mt-3 text-center" v-if="getDetail.video != null">
                                                    <div v-html="getDetail.video"></div>
                                                </div>
                                            </b-card-text>
                                        </b-tab>

                                        <b-tab title="Write Review">
                                            <b-card-text>
                                                <form class="theme-form" v-if="isLogin" @submit.prevent="postReview" >
                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <label>Rating</label>
                                                            <div>
                                                                <star-rating @rating-selected="setRating" :show-rating="false" :star-size="20"></star-rating>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mt-2">
                                                            <label for="review">Write Review</label>
                                                            <textarea class="form-control" placeholder="Wrire Your Testimonial Here" id="exampleFormControlTextarea1" rows="6" v-model="review.review"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button class="btn btn-solid" type="submit">Submit YOur Review</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div v-else>
                                                    Please Login for give Review
                                                </div>
                                                <div class="col-sm-12 mt-5">
                                                    <ul class="review-section">
                                                        <li v-for="rev in reviews">
                                                            <div class="media">
                                                                <img :src='"frontimages/avtar.jpg"' alt="Generic placeholder image" />
                                                                <div class="media-body">
                                                                    <h6>
                                                                        {{ rev.customer.firstname }}
                                                                        <span>( {{ new Date(rev.created_at).toLocaleDateString() }} )</span>
                                                                    </h6>
                                                                    <p class="rating">  
                                                                        <span  v-for="(n, index) in 5">
                                                                            <i  class="fa fa-star"  v-if="(ratings >= n)" ></i>  
                                                                            <i  class="fa fa-star no"  v-else ></i> 
                                                                        </span>
                                                                    </p>                       
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>

                                            </b-card-text>
                                        </b-tab>
                                    </b-tabs>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <relatedProduct v-if="getDetail.category_id" :category="getDetail.category_id" />
    </section>
    <Footer />
    <quickviewModel :openModal="showquickviewmodel" :productData="quickviewproduct" :image-src="imageSrc" />
</div>
</template>

<script>
import productSidebar from '../components/widgets/product-sidebar'
import Breadcrumbs from '../components/widgets/breadcrumbs'
import relatedProduct from '../components/widgets/related-products'
import imageZoom from 'vue-image-zoomer';
import Timer from '../components/widgets/timer'
import quickviewModel from '../components/widgets/quickview'
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
export default {
    components: {
        Header,
		Footer,
        Breadcrumbs,
        Timer,
        productSidebar,
        quickviewModel,
        relatedProduct,
        imageZoom
    },
    computed: {
        swiper() {
            return this.$refs.mySwiper.swiper
        },
        currency() {
            return this.$store.state.siteCurrency;
        },
        isLogin() {
            return this.$store.state.isLogin;
        },
        companyinfo() {
          return this.$store.state.companyInfo;
        },

    },
    data() {
        return {
            quickviewproduct: {},
            showquickviewmodel: false,
            review: {
                rating: 0,
                pd_id: this.$route.params.id,
            },
            ratings: 0,
            loading: false,
            reviews: [],
            getDetail: {},
            counter: 1,
            imageSrc: "",
            selectedSize: null,
            activeColor: '',
            qty: '',
            size: [],
            productTYpe: '',
            productId: '',
            colorActive: null,
            swiperOption: {
                zoom: true,
                slidesPerView: 1,
                spaceBetween: 20,
                freeMode: true,

            },
            swiperOption1: {
                slidesPerView: 3,
                spaceBetween: 30,
                freeMode: true,
                centeredSlides: false
            },
            sharing: {
                url: window.location.href,
                title: '',
                description: '',
                quote: ' ',
                hashtags: '',
                twitterUser: '',
                media: ''
            },
            meta: {},
            networks: [{
                    network: 'facebook',
                    name: 'Facebook',
                    icon: ' fa fa-facebook '
                },
                {
                    network: 'twitter',
                    name: 'Twitter',
                    icon: ' fa fa-twitter'
                },
                {
                    network: 'whatsapp',
                    name: 'Whatsapp',
                    icon: ' fa fa-whatsapp'
                },
                {
                    network: 'linkedin',
                    name: 'LinkedIn',
                    icon: ' fa fa-linkedin'
                },
                {
                    network: 'messenger',
                    name: 'Messenger',
                    icon: ' fa fa-comments-o'
                },
                {
                    network: 'telegram',
                    name: 'Telegram',
                    icon: ' fa fa-telegram'
                },
            ]
        };
    }, 
    // watch: {
    //    // call the method if the route changes
    //    '$route': {
    //      handler: 'asyncData',
    //      immediate: true // runs immediately with mount() instead of calling method on mount hook
    //    }
    // },   
    created() {
        this.getProductDetail();
        this.getReviews();
        this.getMeta();
    },
    methods: {
        async getProductDetail() {
            this.loading = true;
            let dataObj = {
                'name': this.$route.params.pdname.replace(/-/g, ' ')
            };
            let productData = await this.$root.getFrontData(dataObj, '/api/productdetails');
            this.getDetail = productData.data.data[0];
            this.imageSrc = productData.data.url;
            this.sharing.url = window.location.href;
            this.sharing.title = this.getDetail.pd_name;
            this.sharing.description = this.getDetail.pd_description;
            this.sharing.hashtags = this.getDetail.meta_keyword;
            this.sharing.quote = this.getDetail.meta_description;
            this.sharing.media = this.imageSrc + this.getDetail.pd_thumbnail;


            if(this.getDetail.avg_rating.length > 0){
                //console.log(this.product.avg_rating.length);
                this.ratings=this.getDetail.avg_rating[0].aggregate;
            }
        },
        async getMeta() {
            let dataObj = {
                'meta_page': 'product/details',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
            this.loading = false;
        },
        async postReview() {
            await this.$root.getDetailsData(this.review, '/api/customer/review').then(res => {
                Vue.$toast.open({
                    message: res.data.message,
                    position: "top-right",
                    type: "success",
                    duration: 3000,
                    dismissible: false,
                });
                this.getReviews();
            }).catch(err => {
                Vue.$toast.open({
                    message: "Product Is not added to your wishlist.",
                    position: "top-right",
                    type: "error",
                    duration: 3000,
                    dismissible: false,
                });
            })
        },
        async getReviews() {
            let dataObj = {
                'pd_id': this.$route.params.id
            };
            let res = await this.$root.getFrontData(dataObj, '/api/reviewshow');
            this.reviews = res.data.data;
        },
        // Item Count
        increment() {
            this.counter++
        },
        decrement() {
            if (this.counter > 1) this.counter--
        },
        slideTo(id) {
            this.swiper.slideTo(id, 1000, false)
        },
        addItemToCart(proId) {
            let session_id = JSON.parse(sessionStorage.getItem("session_id"));
            let sessionId = session_id.id;
            let dataObj = {
                'pd_id': proId,
                'session_id': sessionId,
                'ct_qty': this.counter,
                'size_id': this.selectedSize,
                'color_id': this.activeColor
            }
            this.$store.dispatch("addToCart", dataObj);
        },
        buyNow(proId) {
          let session_id = JSON.parse(sessionStorage.getItem("session_id"));
            let sessionId = session_id.id;
            let dataObj = {
                'pd_id': proId,
                'session_id': sessionId,
                'ct_qty': this.counter,
                'size_id': this.selectedSize,
                'color_id': this.activeColor
            }
          this.$store.dispatch("addToCart", dataObj);
          this.$router.push('/checkout')
        },
        addToWishlist: function (proId) {
            let session_id = JSON.parse(sessionStorage.getItem("session_id"));
            let sessionId = session_id.id;
            let dataObj = {
                pd_id: proId,
                session_id: sessionId,
            };
            this.$root
                .getFrontData(dataObj, `/api/wishlist`)
                .then((res) => {
                    Vue.$toast.open({
                        message: res.data.message,
                        position: "top-right",
                        type: "success",
                        duration: 3000,
                        dismissible: false,
                    });
                })
                .catch((err) => {
                    Vue.$toast.open({
                        message: "Product Is not added to your wishlist.",
                        position: "top-right",
                        type: "error",
                        duration: 3000,
                        dismissible: false,
                    });
                });
        },
    },
    mounted() {},    
    metaInfo() {
        return {
            title: this.meta.meta_name + this.getDetail.pd_name ,
            meta: [
                { name: 'description', content: this.getDetail.meta_description },
                { name: 'keywords', content: this.getDetail.meta_keyword },

                { property: 'og:url', content: window.location.href  },
                { property: 'og:type', content: 'article' },
                { property: 'og:title', content: this.getDetail.pd_name },
                { property: 'og:description', content: this.getDetail.meta_description },
                { property: 'og:image',  content: this.imageSrc + this.getDetail.pd_thumbnail },
                { property: 'og:site_name', content: this.meta.meta_name + this.getDetail.pd_name },

                { name: 'twitter:card', content: 'summary' },
                { name: 'twitter:title', content: this.getDetail.pd_name },
                { name: 'twitter:description', content: this.meta.meta_content },
                { name: 'twitter:image', content: this.imageSrc + this.getDetail.pd_thumbnail },
                { name: 'robots', content: 'index,follow' },
                
            ]
        }
    },
};
</script>
