<template>
<div>
    <b-modal id="modal-lg" size="lg" centered title="Quickview" :hide-footer="true" v-if="openModal">
        <div class="row quickview-modal">
            <div class="col-lg-6 col-xs-12">
                <div class="quick-view-img">
                    <div v-swiper:mySwiper="swiperOption">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img :src='imageSrc + productData.pd_thumbnail' id="quickProImgsthum" class="img-fluid bg-img" alt="imag.alt" />
                            </div>
                            <div class="swiper-slide" v-for="(image,index) in productData.productimages" :key="index">
                                <img :src='imageSrc + image.pro_img_name' :id="'quickProImgs'+image.id" class="img-fluid bg-img" alt="imag.alt" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 rtl-text">
                <div class="product-right">
                    <h2>{{productData.pd_name}}</h2>
                    <h3 v-if="productData.onsale_stat">
                        {{ currency + productData.pd_price }}
                        <del>{{ currency + productData.pd_prev_price }}</del>
                    </h3>
                    <h3 v-else>{{ currency + productData.pd_price  }}</h3>
                    <ul class="color-variant" v-if="productData.productcolors.length > 0">
                        <li v-for="(variant,variantIndex) in  productData.productcolors" :key="variantIndex" :class="{ active: activeColor == variant.id }" @click="activeColor = variant.id">
                            <a :class="[variant.color.color_name]" v-bind:style="{ 'background-color' : variant.color.color_name}"></a>
                        </li>
                    </ul>
                    <div class="product-description border-product" v-if="productData.productsizes.length > 0">
                        <h6 class="product-title">select size</h6>
                        <div class="size-box">
                            <ul>
                                <li class="product-title" v-for="(size,index) in productData.productsizes" :key="index" v-bind:class="{ active: selectedSize == size.id}" @click="selectedSize = size.id">
                                    <a href="javascript:void(0)">{{size.size.size_display}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-product">
                        <h6 class="product-title">product details</h6>
                        <p v-html="productDetailMinimized"></p>
                    </div>
                    <div class="product-buttons">
                        <a href="javascript:void(0)" @click="addItemToCart(productData.id)" class="btn btn-solid">add to cart</a>
                        <router-link class="btn btn-solid" :to="{ name: 'productdetails', params: { pdname: productData.pd_name.replace(/\s+/g, '-').toLowerCase() }}">
                            View Detail
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</div>
</template>

<script>
export default {
    props: ['openModal', 'productData', 'imageSrc'],
    data() {
        return {
            swiperOption: {
                slidesPerView: 1,
                spaceBetween: 20,
                freeMode: true
            },
            colorActive: null,
            selectedSize: null,
            activeColor: '',
            qty: '',
            size: [],
        }
    },
    computed: {
        currency() {
            return this.$store.state.siteCurrency;
        },
        productDetailMinimized(){
            return this.productData.product_detail ? this.productData.product_detail.substring(0,250) : this.productData.product_detail;
        }
    },
    created() {

    },
    methods: {
        addItemToCart(proId) {
            let session_id = JSON.parse(sessionStorage.getItem("session_id"));
            let sessionId = session_id.id;
            let dataObj = {
                'pd_id': proId,
                'session_id': sessionId,
                'ct_qty': 1,
                'size_id': this.selectedSize,
                'color_id': this.activeColor 
            }
            this.$store.dispatch("addToCart", dataObj);
        },
        // // add to cart
        // addToCart: function (product) {
        //     this.$store.dispatch('cart/addToCart', product)
        // },
        // // Display Sale Price Discount
        // discountedPrice(product) {
        //     return product.price - (product.price * product.discount / 100)
        // }
    }
}
</script>
