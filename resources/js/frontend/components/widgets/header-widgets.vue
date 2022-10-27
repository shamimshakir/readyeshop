<template>
    <div>
        <div class="icon-nav">
            <ul>
                <li class="onhover-div mobile-search">
                    <div>
                        <img alt src="https://vue.pixelstrap.com/multikart/_nuxt/img/search.4381799.png" @click="openSearch()" class="img-fluid" />
                        <i class="ti-search" @click="openSearch()"></i>
                    </div>
                    <div id="search-overlay" class="search-overlay" :class="{ opensearch: search }">
                        <div>
                            <span class="closebtn" @click="closeSearch()" title="Close Overlay">×</span>
                            <div class="overlay-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <form>
                                                <div class="form-group mb-0">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="searchString"
                                                        placeholder="Search a Product"
                                                    />
                                                </div>
                                                <button type="button" class="btn btn-primary">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </form>
                                            <ul class="search-results" v-if="searchItems.length">
                                                <li
                                                    v-for="(product, index) in searchItems"
                                                    :key="index"
                                                    class="product-box"
                                                >
                                                    <div class="img-wrapper">
                                                        <img
                                                            :src="imageSrc + product.pd_thumbnail"
                                                            class="img-fluid bg-img"
                                                            :key="index"
                                                        />
                                                    </div>
                                                    <div class="product-detail">
                                                        <router-link
                                                            :to="{
                                                                name: 'productdetails',
                                                                params: {
                                                                    pdname: product.pd_name.replace(/\s+/g, '-').toLowerCase(),
                                                                    id: product.id,
                                                                },
                                                            }"
                                                        >
                                                            <h6>{{ product.pd_name }}</h6>
                                                        </router-link>
                                                        <h4>{{ currency }}{{ product.pd_price }}</h4>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="onhover-div mobile-cart">
                    <div>
                        <img
                            alt
                            src="https://vue.pixelstrap.com/multikart/_nuxt/img/cart.11c110d.png"
                            class="img-fluid"
                        />
                        <i class="ti-shopping-cart"></i>
                        <span class="cart_qty_cls">{{ cartItemCount }}</span>
                    </div>
                    <ul class="show-div shopping-cart" v-if="!cartItemCount">
                        <li>Your cart is currently empty.</li>
                    </ul>
                    <ul class="show-div shopping-cart">
                        <li v-for="(item, index) in cartItems" :key="index">
                            <div class="media">
                                <router-link :to="{ path: '/product/sidebar/' + item.id }">
                                    <img
                                        alt
                                        class="mr-3"
                                        :src="cartImgSrc + item.products.pd_thumbnail"
                                    />
                                </router-link>
                                <div class="media-body">
                                    <router-link :to="{ path: '/product/sidebar/' + item.id }">
                                        <h4>{{ item.products.pd_name }}</h4>
                                    </router-link>
                                    <h4>
                                        <span>
                                            {{ item.ct_qty }} x {{
                                                currency
                                            }}{{ item.products.pd_price }}
                                        </span>
                                    </h4>
                                </div>
                            </div>
                            <div class="close-circle">
                                <span @click="removeCartItem(item.id)">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="total">
                                <h5>
                                    subtotal :
                                    <span>{{ currency }}{{ cartTotal }}</span>
                                </h5>
                            </div>
                        </li>
                        <li>
                            <div class="buttons">
                                <router-link :to="{ path: '/cart' }" :class="'view-cart'">view cart</router-link>
                                <router-link
                                    :to="{ path: '/checkout' }"
                                    :class="'checkout'"
                                >checkout</router-link>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: false,
            searchString: "",
            searchItems: [],
            imageSrc: "",
        };
    },
    created() { },
    computed: {
        currency() {
            return this.$store.state.siteCurrency;
        },
        cartItems() {
            return this.$store.getters.cartProducts;
        },
        cartImgSrc() {
            return this.$store.getters.cartImgSrc;
        },
        cartTotal() {
            return this.$store.getters.cartTotal;
        },
        cartItemCount() {
            return this.$store.getters.cartItemCount;
        },
    },
    watch: {
        searchString: function (val) {
            if (val) {
                let dataObj = {
                    name: val
                }
                this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=20`).then(res => {
                    this.searchItems = res.data.data.data;
                    this.imageSrc = res.data.url;
                }).catch(err => {
                    console.dir(err)
                });
            } else {
                this.searchItems = [];
            }
        }
    },
    methods: {
        openSearch() {
            this.search = true;
        },
        closeSearch() {
            this.search = false;
            this.searchString = "";
        },
        async removeCartItem(cId) {
            this.$store.dispatch("removeCart", cId);
        },
    },
};
</script>
