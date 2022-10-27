<template>
    <div>
        <footer class="footer-light">
            <div class="light-layout">
                <div class="container">
                    <section class="small-section border-section border-top-0">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="subscribe">
                                    <div>
                                        <h4>KNOW IT ALL FIRST!</h4>
                                        <p>Never Miss Anything From Multikart By Signing Up To Our Newsletter.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <form
                                    class="form-inline subscribe-form auth-form needs-validation"
                                    @submit.prevent="suscrives"
                                >
                                    <div class="form-group mx-sm-3">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            v-model="suscrived.email"
                                            id="mce-email"
                                            placeholder="Enter your email"
                                            required="required"
                                        />
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-solid"
                                        id="mc-submit"
                                    >subscribe</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <section class="light-layout">
                <div class="container">
                    <div class="row footer-theme partition-f">
                        <div class="col-lg-4 col-md-6">
                            <div class="footer-title footer-mobile-title">
                                <h4>about</h4>
                            </div>
                            <div class="footer-contant">
                                <div class="footer-logo">
                                    <img :src="companyimg + companyinfo.logo" class="img-fluid" alt />
                                </div>
                                <p>{{ companyinfo.website_slogan }}</p>
                                <p>{{ companyinfo.comp_address }}</p>
                                <div class="footer-social">
                                    <ul>
                                        <li v-for="(item, index) in socialitems">
                                            <a v-bind:href="item.url">
                                                <i v-bind:class="item.icon" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col offset-xl-1">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>my account</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <li>
                                            <router-link
                                                :to="{ path: '/account/wishlist' }"
                                            >WishList</router-link>
                                        </li>
                                        <li>
                                            <router-link :to="{ path: '/account/compare' }">Compare</router-link>
                                        </li>
                                        <li v-if="isLogin">
                                            <router-link
                                                :to="{ path: '/account/dashboard' }"
                                            >Dashboard</router-link>
                                        </li>
                                        <li>
                                            <a v-if="isLogin" v-on:click="logout">Logout</a>
                                            <router-link
                                                v-else
                                                :to="{ path: '/account/login' }"
                                            >Login</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>why we choose</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul>
                                        <li v-for="(item, index) in pcitems">
                                            <router-link
                                                :to="{ name: 'others', params: { pagename: item.page_name } }"
                                            >{{ item.page_title }}</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="sub-title">
                                <div class="footer-title">
                                    <h4>contact information</h4>
                                </div>
                                <div class="footer-contant">
                                    <ul class="contact-list">
                                        <li>
                                            <i class="fa fa-phone"></i>
                                            {{ companyinfo.contact_phone }}
                                        </li>
                                        <li>
                                            <i class="fa fa-envelope-o"></i>
                                            {{ companyinfo.contact_email }}
                                        </li>
                                        <li>
                                            <router-link :to="{ path: 'contact' }">Contact</router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="sub-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <div class="footer-end">
                                <p>
                                    <i class="fa fa-copyright" aria-hidden="true"></i>
                                    2020-{{ currentDate() }} {{ companyinfo.company_name }}-All Rights Reserved
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12">
                            <div class="payment-card-bottom">
                                <ul>
                                    <li v-for="(item, index) in paymentitems">
                                        <a href="#">
                                            <img :src="imageSrc + item.logo" alt />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            pcitems: [],
            socialitems: [],
            paymentitems: [],
            imageSrc: "",

            suscrived: {
                email: "",
            },

            errors: [],
        };
    },
    created() {
        this.getPageContentsDetail();
        this.getSocialDetail();
        this.getpaymentDetail();
    },
    computed: {
        companyinfo() {
            return this.$store.state.companyInfo;
        },
        companyimg() {
            return this.$store.getters.companyImg;
        },
        isLogin() {
            return this.$store.state.isLogin;
        },
    },
    methods: {
        currentDate() {
            const current = new Date();
            let year = `${current.getFullYear()}`;
            return year;
        },
        async getPageContentsDetail() {
            let dataObj = {
                active_status: 1
            };
            let pagecontentData = await this.$root.getFrontData(dataObj, `/api/pagecontent_param`);
            this.pcitems = pagecontentData.data.data;
        },
        async getSocialDetail() {
            let dataObj = {
                active_status: 1
            };
            let socialData = await this.$root.getFrontData(dataObj, `/api/social_param`);
            this.socialitems = socialData.data.data;
        },
        async getpaymentDetail() {
            let dataObj = {
                status: 1
            };
            let paymentData = await this.$root.getFrontData(dataObj, `/api/paymenticon_param`);
            this.paymentitems = paymentData.data.data;
            this.imageSrc = paymentData.data.url;
        },
        logout() {
            sessionStorage.removeItem("loginInfo");
            this.$store.commit("UPDATE_TOKEN_FROM_LOGIN", null);
            this.$store.commit("UPDATE_ISLOGIN", false);
            this.isAuthenticated = false;
            this.$router.push("/account/login").catch(() => { });
            //   location.reload();
        },
        suscrives() {
            this.$root.getFrontData(this.suscrived, `/api/subscribes`)
                .then(res => {
                    Vue.$toast.open({
                        message: res.data.message,
                        position: 'top-right',
                        type: 'success',
                        duration: 3000,
                        dismissible: false,
                    });
                }).catch(error => {
                    console.dir(error);
                    let res = JSON.parse(error.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(error.request.response).validation_errors;
                        Vue.$toast.open({
                            message: this.errors.email,
                            position: 'top-right',
                            type: 'warning',
                            duration: 3000,
                            dismissible: false,
                        });

                    } else {
                        Vue.$toast.open({
                            message: "Failed to Subscribe",
                            position: 'top-right',
                            type: 'warning',
                            duration: 3000,
                            dismissible: false,
                        });
                    }
                })
        },
    },
};
</script>
