<template>
<div>
    <Breadcrumbs :title="getDetail.pd_name" />
    <section class="section-b-space">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <productSidebar />
                    </div>
                    <div class="col-lg-9 col-sm-12 col-xs-12 productdetail">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div v-swiper:mySwiper="swiperOption" ref="mySwiper">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img :src="imageSrc + getDetail.pd_thumbnail" id="pd_thumbnail" class="img-fluid bg-img" key="0" />
                                            </div>
                                            <div class="swiper-slide" v-for="(pro__img,index) in getDetail.productimages" :key="index + 1">
                                                <img :src="imageSrc + pro__img.pro_img_name" :id="pro__img.id" class="img-fluid bg-img" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 slider-nav-images">
                                            <div v-swiper:mySwiper1="swiperOption1">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <img :src="imageSrc + getDetail.pd_thumbnail" id="pd_thumbnail" class="img-fluid bg-img" 
                                                        @click="slideTo(0)" />
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
                                            <li v-bind:class="{ active: activeColor == variant}" v-for="(variant,variantIndex) in getDetail.productcolors" :key="variantIndex">
                                                <a :class="[variant.color.color_name]" v-bind:style="{ 'background-color' : variant.color.color_name}" @click="sizeVariant(getDetail.variants[variantIndex].image_id, variantIndex, variant)"></a>
                                            </li>
                                        </ul>
                                        <div class="pro_inventory" v-if="getDetail.pd_qty < 8">
                                            <p class="active"> Hurry! We have only {{ getDetail.pd_qty }} product in stock. </p>
                                            <div class="inventory-scroll">
                                                <span style="width: 95%;"></span>
                                            </div>
                                        </div>
                                        <div class="product-description border-product">
                                            <h6 class="product-title size-text">
                                                select size
                                                <span>
                                                    <a href="javascript:void(0)" v-b-modal.modal-1>size chart</a>
                                                </span>
                                            </h6>
                                            <div class="size-box">
                                                <ul>
                                                    <li class="product-title" v-bind:class="{ active: selectedSize == size}" v-for="(size,index) in getDetail.productsizes" :key="index">
                                                        <a href="javascript:void(0)" @click="changeSizeVariant(size)">{{size.size.size_display}}</a>
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
                                            <a href="javascript:void(0)"  @click="addItemToCart(getDetail.id)" title="Add to cart">
                                                <button class="btn btn-solid" title="Add to cart">Add To Cart</button>
                                            </a>

                                             
                                            <button class="btn btn-solid" title="buy now" @click="buyNow(getDetail, counter)" :disabled="counter > getDetail.stock">Buy Now</button>
                                        </div>
                                        <div class="border-product">
                                            <h6 class="product-title">product details</h6>
                                            <!-- <p>{{getDetail.product_detail.substring(0,200)+"...."}}</p> -->
                                        </div>
                                        <div class="border-product">
                                            <h6 class="product-title">share it</h6>
                                            <div class="product-icon">
                                                <ul class="product-social">
                                                    <li v-for="network in networks">
                                                        <ShareNetwork      
                                                            :network="network.network"
                                                            :key="network.network"           
                                                            :url="sharing.url"
                                                            :title="sharing.title"
                                                            :description="sharing.description"
                                                            :quote="sharing.quote"
                                                            :hashtags="sharing.hashtags"
                                                            :twitterUser="sharing.twitterUser"
                                                          >
                                                            <i :class="network.icon"></i>
                                                      </ShareNetwork>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-facebook"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-google-plus"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-instagram"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-rss"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                                
                                                    <button class="wishlist-btn" @click="addToWishlist(getDetail.id)">
                                                        <i class="fa fa-heart"></i>
                                                        <span class="title-font">Add To WishList</span>
                                                    </button>
                                               
                                            </div>
                                        </div>
                                        <div class="border-product">
                                            <h6 class="product-title">Time Reminder</h6>
                                            <!-- <Timer date="December 20, 2020" /> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="tab-product m-0">
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <b-tabs card>
                                        <b-tab title="Description" active>
                                            <b-card-text v-html="getDetail.product_detail"></b-card-text>
                                        </b-tab>
                                        <b-tab title="Details">
                                            <b-card-text>
                                                {{getDetail.description}}
                                                <div class="single-product-tables">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>Febric</td>
                                                                <td>Chiffon</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Color</td>
                                                                <td>Red</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Material</td>
                                                                <td>Crepe printed</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>Length</td>
                                                                <td>50 Inches</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Size</td>
                                                                <td>S, M, L .XXL</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </b-card-text>
                                        </b-tab>
                                        <b-tab title="Video">
                                            <b-card-text>
                                                <div class="mt-3 text-center">
                                                    <iframe width="560" height="315" src="https://www.youtube.com/embed/BUWzX78Ye_8" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                                </div>
                                            </b-card-text>
                                        </b-tab>
                                        <b-tab title="Write Review">
                                            <b-card-text>
                                                <form class="theme-form">
                                                    <div class="form-row">
                                                        <div class="col-md-12">
                                                            <div class="media">
                                                                <label>Rating</label>
                                                                <div class="media-body ml-3">
                                                                    <div class="rating three-star">
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name" placeholder="Enter Your name" required />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="email">Email</label>
                                                            <input type="text" class="form-control" id="email" placeholder="Email" required />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="review">Review Title</label>
                                                            <input type="text" class="form-control" id="review" placeholder="Enter your Review Subjects" required />
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="review">Review Title</label>
                                                            <textarea class="form-control" placeholder="Wrire Your Testimonial Here" id="exampleFormControlTextarea1" rows="6"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button class="btn btn-solid" type="submit">Submit YOur Review</button>
                                                        </div>
                                                    </div>
                                                </form>
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
        <!-- <relatedProduct :productTYpe="productTYpe" :productId="productId" /> -->
        <!-- <b-modal id="modal-1" size="md" centered hide-footer>
            <template v-slot:modal-title>{{getDetail.title}}</template>
            <img src="../../../assets/images/size-chart.jpg" alt="size-chart" class="img-fluid" />
        </b-modal> -->


    </section>

</div>
</template>

<script>
import productSidebar from '../components/widgets/product-sidebar'
import Breadcrumbs from '../components/widgets/breadcrumbs'
export default {
    components: {
        Breadcrumbs,
        // Timer,
        productSidebar,
        // relatedProduct
    },
    computed: {
        swiper() {
            return this.$refs.mySwiper.swiper
        },
        currency() {
            return this.$store.state.siteCurrency;
        },
    },
    data() {
        return {
            getDetail: {},
            counter: 1,
            imageSrc: "",
            selectedSize: '',
            activeColor: '',
            qty: '',
            size: [],
            productTYpe: '',
            productId: '',
            swiperOption: {
                slidesPerView: 1,
                spaceBetween: 20,
                freeMode: true
            },
            swiperOption1: {
                slidesPerView: 3,
                spaceBetween: 30,
                freeMode: true,
                centeredSlides: false
            },
            sharing: {
                url: 'https://news.vuejs.org/issues/180',
                title: 'Say hi to Vite! A brand new, extremely fast development setup for Vue.',
                description: 'This week, I’d like to introduce you to "Vite", which means "Fast". It’s a brand new development setup created by Evan You.',
                quote: 'The hot reload is so fast it\'s near instant. - Evan You',
                hashtags: 'vuejs,vite,javascript',
                twitterUser: 'youyuxi'
              },
            networks: [
                { network: 'facebook', name: 'Facebook', icon: ' fa fa-lg fa-facebook-f'},
                { network: 'googleplus', name: 'Googleplus',icon: 'fa fa-google-plus'},
                { network: 'twitter', name: 'Twitter', icon: ' fa fa-lg fa-twitter' },
                { network: 'whatsapp', name: 'Whatsapp', icon: ' fa fa-lg fa-whatsapp'},
                { network: 'linkedin', name: 'LinkedIn', icon: ' fa fa-lg fa-linkedin'},
                { network: 'messenger', name: 'Messenger', icon: ' fa fa-lg fa-facebook-messenger'},
                { network: 'telegram', name: 'Telegram', icon: ' fa fa-lg fa-telegram-plane'},
                { network: 'viber', name: 'Viber', icon: ' fa fa-lg fa-viber'},
                { network: 'skype', name: 'Skype', icon: ' fa fa-lg fa-skype', color: '#00aff0' },
                { network: 'sms', name: 'SMS', icon: ' fa fa-lg fa-comment-dots', color: '#333333' },                    
                { network: 'instapaper', name: 'Instapaper', icon: ' fa fa-lg fa-italic', color: '#428bca' },
                { network: 'line', name: 'Line', icon: ' fa fa-lg fa-line', color: '#00c300' },
                { network: 'pinterest', name: 'Pinterest', icon: ' fa fa-lg fa-pinterest', color: '#bd081c' },
                    
                    
                ]
        };
    },
    created() {
        this.getProductDetail();
    },
    methods: {
        async getProductDetail() {
            let dataObj = {
                'id': this.$route.params.id
            };
            let productData = await this.$root.getFrontData(dataObj, '/api/productdetails');
            this.getDetail = productData.data.data[0];
            this.imageSrc = productData.data.url;
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
          this.$store.dispatch("addToCart", proId);
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
};
</script>
