"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[923],{2649:(t,e,a)=>{a.d(e,{Z:()=>o});var i=a(7897),s=a.n(i),r=a(1519),n=a.n(r)()(s());n.push([t.id,".toggle-nav.toggle-button[data-v-cfd838c6]{z-index:1}","",{version:3,sources:["webpack://./resources/js/frontend/components/widgets/navbar.vue"],names:[],mappings:"AA6DE,2CACE,SA5DJ",sourcesContent:["\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n.toggle-nav {\n  &.toggle-button {\n    z-index: 1;\n  }\n}\n"],sourceRoot:""}]);const o=n},9380:(t,e,a)=>{a.d(e,{Z:()=>c});const i={data:function(){return{}},computed:{rightSidebarVal:function(){return this.$store.state.rightSidebarVal}},methods:{changeRightSidebarVal:function(t){this.$store.commit("CHANGE_RIGHT_SIDEBAR",t)}}};var s=a(3379),r=a.n(s),n=a(2649),o={insert:"head",singleton:!1};r()(n.Z,o);n.Z.locals;const c=(0,a(1900).Z)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"main-navbar"},[a("div",{attrs:{id:"mainnav"}},[a("div",{staticClass:"toggle-nav",on:{click:function(e){return t.changeRightSidebarVal(!0)}}},[a("i",{staticClass:"fa fa-bars sidebar-bar"})]),t._v(" "),a("ul",{staticClass:"nav-menu",class:{opennav:t.rightSidebarVal}},[a("li",{staticClass:"back-btn"},[a("div",{staticClass:"mobile-back text-right"},[a("span",{on:{click:function(e){return t.changeRightSidebarVal(!1)}}},[t._v("Back")]),t._v(" "),a("i",{staticClass:"fa fa-angle-right pl-2",attrs:{"aria-hidden":"true"}})])]),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/"}}},[t._v("Home")])],1),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/shop"}}},[t._v("Shop")])],1),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/about"}}},[t._v("About us")])],1),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/faq"}}},[t._v("FAQ")])],1),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/contact"}}},[t._v("Contact")])],1)])])])])}),[],!1,null,"cfd838c6",null).exports},7249:(t,e,a)=>{a.d(e,{Z:()=>s});const i={props:["openModal","productData","imageSrc"],data:function(){return{swiperOption:{slidesPerView:1,spaceBetween:20,freeMode:!0},colorActive:null,selectedSize:null,activeColor:"",qty:"",size:[]}},computed:{currency:function(){return this.$store.state.siteCurrency},productDetailMinimized:function(){return this.productData.product_detail?this.productData.product_detail.substring(0,250):this.productData.product_detail}},created:function(){},methods:{addItemToCart:function(t){var e={pd_id:t,session_id:JSON.parse(sessionStorage.getItem("session_id")).id,ct_qty:1,size_id:this.selectedSize,color_id:this.activeColor};this.$store.dispatch("addToCart",e)}}};const s=(0,a(1900).Z)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.openModal?a("b-modal",{attrs:{id:"modal-lg",size:"lg",centered:"",title:"Quickview","hide-footer":!0}},[a("div",{staticClass:"row quickview-modal"},[a("div",{staticClass:"col-lg-6 col-xs-12"},[a("div",{staticClass:"quick-view-img"},[a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},[a("div",{staticClass:"swiper-slide"},[a("img",{staticClass:"img-fluid bg-img",attrs:{src:t.imageSrc+t.productData.pd_thumbnail,id:"quickProImgsthum",alt:"imag.alt"}})]),t._v(" "),t._l(t.productData.productimages,(function(e,i){return a("div",{key:i,staticClass:"swiper-slide"},[a("img",{staticClass:"img-fluid bg-img",attrs:{src:t.imageSrc+e.pro_img_name,id:"quickProImgs"+e.id,alt:"imag.alt"}})])}))],2)])])]),t._v(" "),a("div",{staticClass:"col-lg-6 rtl-text"},[a("div",{staticClass:"product-right"},[a("h2",[t._v(t._s(t.productData.pd_name))]),t._v(" "),t.productData.onsale_stat?a("h3",[t._v("\n                        "+t._s(t.currency+t.productData.pd_price)+"\n                        "),a("del",[t._v(t._s(t.currency+t.productData.pd_prev_price))])]):a("h3",[t._v(t._s(t.currency+t.productData.pd_price))]),t._v(" "),t.productData.productcolors.length>0?a("ul",{staticClass:"color-variant"},t._l(t.productData.productcolors,(function(e,i){return a("li",{key:i,class:{active:t.activeColor==e.id},on:{click:function(a){t.activeColor=e.id}}},[a("a",{class:[e.color.color_name],style:{"background-color":e.color.color_name}})])})),0):t._e(),t._v(" "),t.productData.productsizes.length>0?a("div",{staticClass:"product-description border-product"},[a("h6",{staticClass:"product-title"},[t._v("select size")]),t._v(" "),a("div",{staticClass:"size-box"},[a("ul",t._l(t.productData.productsizes,(function(e,i){return a("li",{key:i,staticClass:"product-title",class:{active:t.selectedSize==e.id},on:{click:function(a){t.selectedSize=e.id}}},[a("a",{attrs:{href:"javascript:void(0)"}},[t._v(t._s(e.size.size_display))])])})),0)])]):t._e(),t._v(" "),a("div",{staticClass:"border-product"},[a("h6",{staticClass:"product-title"},[t._v("product details")]),t._v(" "),a("p",{domProps:{innerHTML:t._s(t.productDetailMinimized)}})]),t._v(" "),a("div",{staticClass:"product-buttons"},[a("a",{staticClass:"btn btn-solid",attrs:{href:"javascript:void(0)"},on:{click:function(e){return t.addItemToCart(t.productData.id)}}},[t._v("add to cart")]),t._v(" "),a("router-link",{staticClass:"btn btn-solid",attrs:{to:{name:"productdetails",params:{pdname:t.productData.pd_name.replace(/\s+/g,"-").toLowerCase()}}}},[t._v("\n                            View Detail\n                        ")])],1)])])])]):t._e()],1)}),[],!1,null,null,null).exports},9280:(t,e,a)=>{a.d(e,{Z:()=>s});const i={data:function(){return{}},created:function(){},computed:{isLogin:function(){return this.$store.state.isLogin},companyinfo:function(){return this.$store.state.companyInfo}},methods:{logout:function(){sessionStorage.removeItem("loginInfo"),this.$store.commit("UPDATE_TOKEN_FROM_LOGIN",null),this.$store.commit("UPDATE_ISLOGIN",!1),this.isAuthenticated=!1,this.$router.push("/account/login").catch((function(){}))}}};const s=(0,a(1900).Z)(i,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"top-header"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6"},[a("div",{staticClass:"header-contact"},[a("ul",[a("li",[t._v("Welcome to "+t._s(t.companyinfo.company_name))]),t._v(" "),a("li",[a("i",{staticClass:"fa fa-phone",attrs:{"aria-hidden":"true"}}),t._v("Call Us:\n              "+t._s(t.companyinfo.contact_phone)+"\n            ")])])])]),t._v(" "),a("div",{staticClass:"col-lg-6 text-right"},[a("ul",{staticClass:"header-dropdown"},[a("li",{staticClass:"mobile-wishlist"},[a("router-link",{attrs:{to:{path:"/account/wishlist"}}},[a("i",{staticClass:"fa fa-heart",attrs:{"aria-hidden":"true"}})])],1),t._v(" "),a("li",{staticClass:"mobile-compare"},[a("router-link",{attrs:{to:{path:"/account/compare"}}},[a("i",{staticClass:"fa fa-retweet",attrs:{"aria-hidden":"true"}})])],1),t._v(" "),a("li",{staticClass:"onhover-dropdown mobile-account"},[a("i",{staticClass:"fa fa-user",attrs:{"aria-hidden":"true"}}),t._v(" My Account\n\n            "),a("ul",{staticClass:"onhover-show-div"},[a("li",[t.isLogin?a("a",{on:{click:t.logout}},[t._v(" Logout ")]):a("router-link",{attrs:{to:{path:"/account/login"}}},[t._v("Login")])],1),t._v(" "),t.isLogin?a("li",[a("router-link",{attrs:{to:{path:"/account/dashboard"}}},[t._v("\n                  Dashboard\n                ")])],1):t._e()])])])])])])])}),[],!1,null,null,null).exports},3923:(t,e,a)=>{a.r(e),a.d(e,{default:()=>M});var i=a(7757),s=a.n(i),r=a(9280),n=a(9380);function o(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const c={data:function(){return{search:!1,searchString:"",searchItems:[],imageSrc:""}},components:{TopBar:r.Z,Nav:n.Z},computed:{companyinfo:function(){return this.$store.state.companyInfo},companyimg:function(){return this.$store.getters.companyImg},currency:function(){return this.$store.state.siteCurrency},cartItems:function(){return this.$store.getters.cartProducts},cartImgSrc:function(){return this.$store.getters.cartImgSrc},cartTotal:function(){return this.$store.getters.cartTotal},cartItemCount:function(){return this.$store.getters.cartItemCount}},watch:{searchString:function(t){var e=this;if(t){var a={name:t};this.$root.getFrontData(a,"/api/product_param?page=1&limit=20").then((function(t){e.searchItems=t.data.data.data,e.imageSrc=t.data.url})).catch((function(t){console.dir(t)}))}else this.searchItems=[]}},methods:{left_sidebar:function(){this.$store.commit("CHANGE_LEFT_SIDEBAR",!0)},openSearch:function(){this.search=!0},closeSearch:function(){this.search=!1,this.searchString=""},removeCartItem:function(t){var e,a=this;return(e=s().mark((function e(){return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:a.$store.dispatch("removeCart",t);case 1:case"end":return e.stop()}}),e)})),function(){var t=this,a=arguments;return new Promise((function(i,s){var r=e.apply(t,a);function n(t){o(r,i,s,n,c,"next",t)}function c(t){o(r,i,s,n,c,"throw",t)}n(void 0)}))})()}}};var l=a(1900);const u=(0,l.Z)(c,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("header",{staticClass:"header-2 header-6"},[a("div",{staticClass:"mobile-fix-option"}),t._v(" "),a("TopBar"),t._v(" "),a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-sm-12"},[a("div",{staticClass:"main-menu border-section border-top-0"},[a("div",{staticClass:"brand-logo layout2-logo"},[a("router-link",{attrs:{to:{path:"/"},exact:""}},[a("img",{staticClass:"img-fluid",attrs:{src:t.companyimg+t.companyinfo.logo,alt:""}})])],1),t._v(" "),a("div",{staticClass:"pets-search"},[a("form",{staticClass:"form_search",attrs:{role:"form"}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.searchString,expression:"searchString"}],staticClass:"nav-search nav-search-field",attrs:{type:"search",placeholder:"Find the best for your pet..."},domProps:{value:t.searchString},on:{input:function(e){e.target.composing||(t.searchString=e.target.value)}}}),t._v(" "),t._m(0)]),t._v(" "),t.searchItems.length?a("ul",{staticClass:"search-results"},t._l(t.searchItems,(function(e,i){return a("li",{key:i,staticClass:"product-box"},[a("div",{staticClass:"img-wrapper"},[a("img",{key:i,staticClass:"img-fluid bg-img",attrs:{src:t.imageSrc+e.pd_thumbnail}})]),t._v(" "),a("div",{staticClass:"product-detail"},[a("router-link",{attrs:{to:{name:"productdetails",params:{pdname:e.pd_name.replace(/\s+/g,"-").toLowerCase(),id:e.id}}}},[a("h6",[t._v(t._s(e.pd_name))])]),t._v(" "),a("h4",[t._v(t._s(t.currency)+t._s(e.pd_price))])],1)])})),0):t._e()]),t._v(" "),a("div",{staticClass:"menu-right pull-right"},[a("div",{staticClass:"icon-nav"},[a("ul",[a("li",{staticClass:"onhover-div mobile-search"},[t._m(1),t._v(" "),a("div",{staticClass:"search-overlay",class:{opensearch:t.search},attrs:{id:"search-overlay"}},[a("div",[a("span",{staticClass:"closebtn",attrs:{title:"Close Overlay"},on:{click:function(e){return t.closeSearch()}}},[t._v("×")]),t._v(" "),a("div",{staticClass:"overlay-content"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-xl-12"},[a("form",[a("div",{staticClass:"form-group mb-0"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.searchString,expression:"searchString"}],staticClass:"form-control",attrs:{type:"text",placeholder:"Search a Product"},domProps:{value:t.searchString},on:{input:function(e){e.target.composing||(t.searchString=e.target.value)}}})]),t._v(" "),t._m(2)]),t._v(" "),t.searchItems.length?a("ul",{staticClass:"search-results"},t._l(t.searchItems,(function(e,i){return a("li",{key:i,staticClass:"product-box"},[a("div",{staticClass:"img-wrapper"},[a("img",{key:i,staticClass:"img-fluid bg-img",attrs:{src:t.imageSrc+e.pd_thumbnail}})]),t._v(" "),a("div",{staticClass:"product-detail"},[a("router-link",{attrs:{to:{name:"productdetails",params:{pdname:e.pd_name.replace(/\s+/g,"-").toLowerCase(),id:e.id}}}},[a("h6",[t._v(t._s(e.pd_name))])]),t._v(" "),a("h4",[t._v(t._s(t.currency)+t._s(e.pd_price))])],1)])})),0):t._e()])])])])])])]),t._v(" "),a("li",{staticClass:"onhover-div mobile-cart"},[a("div",[a("img",{staticClass:"img-fluid",attrs:{alt:"",src:"https://vue.pixelstrap.com/multikart/_nuxt/img/cart.11c110d.png"}}),t._v(" "),a("i",{staticClass:"ti-shopping-cart"}),t._v(" "),a("span",{staticClass:"cart_qty_cls"},[t._v(t._s(t.cartItemCount))])]),t._v(" "),t.cartItemCount?t._e():a("ul",{staticClass:"show-div shopping-cart"},[a("li",[t._v("Your cart is currently empty.")])]),t._v(" "),a("ul",{staticClass:"show-div shopping-cart"},[t._l(t.cartItems,(function(e,i){return a("li",{key:i},[a("div",{staticClass:"media"},[a("router-link",{attrs:{to:{path:"/product/sidebar/"+e.id}}},[a("img",{staticClass:"mr-3",attrs:{alt:"",src:t.cartImgSrc+e.products.pd_thumbnail}})]),t._v(" "),a("div",{staticClass:"media-body"},[a("router-link",{attrs:{to:{path:"/product/sidebar/"+e.id}}},[a("h4",[t._v(t._s(e.products.pd_name))])]),t._v(" "),a("h4",[a("span",[t._v("\n                                "+t._s(e.ct_qty)+" x "+t._s(t.currency)+t._s(e.products.pd_price)+"\n                              ")])])],1)],1),t._v(" "),a("div",{staticClass:"close-circle"},[a("span",{on:{click:function(a){return t.removeCartItem(e.id)}}},[a("i",{staticClass:"fa fa-times",attrs:{"aria-hidden":"true"}})])])])})),t._v(" "),a("li",[a("div",{staticClass:"total"},[a("h5",[t._v("\n                            subtotal :\n                            "),a("span",[t._v(t._s(t.currency)+t._s(t.cartTotal))])])])]),t._v(" "),a("li",[a("div",{staticClass:"buttons"},[a("router-link",{class:"view-cart",attrs:{to:{path:"/cart"}}},[t._v("view cart")]),t._v(" "),a("router-link",{class:"checkout",attrs:{to:{path:"/checkout"}}},[t._v("checkout")])],1)])],2)])])])])])])])]),t._v(" "),a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-12"},[a("div",{staticClass:"main-nav-center"},[a("Nav")],1)])])])],1)])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn-search",attrs:{type:"submit",name:"nav-submit-button"}},[e("i",{staticClass:"ti-search"})])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("img",{staticClass:"img-fluid",attrs:{src:"https://vue.pixelstrap.com/multikart/_nuxt/img/search.4381799.png",alt:""}}),t._v(" "),a("i",{staticClass:"ti-search"})])},function(){var t=this.$createElement,e=this._self._c||t;return e("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[e("i",{staticClass:"fa fa-search"})])}],!1,null,null,null).exports;function d(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}function p(t){return function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){d(r,i,s,n,o,"next",t)}function o(t){d(r,i,s,n,o,"throw",t)}n(void 0)}))}}const v={data:function(){return{pcitems:[],socialitems:[],paymentitems:[],imageSrc:"",suscrived:{email:""},errors:[]}},created:function(){this.getPageContentsDetail(),this.getSocialDetail(),this.getpaymentDetail()},computed:{companyinfo:function(){return this.$store.state.companyInfo},companyimg:function(){return this.$store.getters.companyImg},isLogin:function(){return this.$store.state.isLogin}},methods:{currentDate:function(){var t=new Date;return"".concat(t.getFullYear())},getPageContentsDetail:function(){var t=this;return p(s().mark((function e(){var a,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a={active_status:1},e.next=3,t.$root.getFrontData(a,"/api/pagecontent_param");case 3:i=e.sent,t.pcitems=i.data.data;case 5:case"end":return e.stop()}}),e)})))()},getSocialDetail:function(){var t=this;return p(s().mark((function e(){var a,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a={active_status:1},e.next=3,t.$root.getFrontData(a,"/api/social_param");case 3:i=e.sent,t.socialitems=i.data.data;case 5:case"end":return e.stop()}}),e)})))()},getpaymentDetail:function(){var t=this;return p(s().mark((function e(){var a,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a={status:1},e.next=3,t.$root.getFrontData(a,"/api/paymenticon_param");case 3:i=e.sent,t.paymentitems=i.data.data,t.imageSrc=i.data.url;case 6:case"end":return e.stop()}}),e)})))()}}};const m=(0,l.Z)(v,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("footer",{staticClass:"footer-light pet-layout-footer"},[a("div",{staticClass:"white-layout"},[a("div",{staticClass:"container"},[a("section",{staticClass:"small-section"},[a("div",{staticClass:"row footer-theme2"},[a("div",{staticClass:"col"},[a("div",{staticClass:"footer-link link-white"},[a("div",{staticClass:"footer-brand-logo"},[a("a",{attrs:{href:"#"}},[a("img",{staticClass:"img-fluid",attrs:{src:t.companyimg+t.companyinfo.logo,alt:""}})])]),t._v(" "),a("div",{staticClass:"social-white"},[a("ul",t._l(t.socialitems,(function(t,e){return a("li",[a("a",{attrs:{href:t.url}},[a("i",{class:t.icon,attrs:{"aria-hidden":"true"}})])])})),0)]),t._v(" "),t._m(0),t._v(" "),a("div",{staticClass:"footer-contant"},[a("ul",[a("li",[a("router-link",{attrs:{to:{path:"/account/wishlist"}}},[t._v("WishList")])],1),t._v(" "),a("li",[a("router-link",{attrs:{to:{path:"/account/compare"}}},[t._v("Compare")])],1),t._v(" "),t.isLogin?a("li",[a("router-link",{attrs:{to:{path:"/account/dashboard"}}},[t._v("Dashboard")])],1):t._e(),t._v(" "),a("li",[t.isLogin?a("a",{on:{click:t.logout}},[t._v("Logout")]):a("router-link",{attrs:{to:{path:"/account/login"}}},[t._v("Login")])],1),t._v(" "),t._l(t.pcitems,(function(e,i){return a("li",[a("router-link",{attrs:{to:{name:"others",params:{pagename:e.page_name}}}},[t._v(t._s(e.page_title))])],1)}))],2)])])])])])])]),t._v(" "),a("div",{staticClass:"sub-footer black-subfooter"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-xl-6 col-md-6 col-sm-12"},[a("div",{staticClass:"footer-end"},[a("p",[a("i",{staticClass:"fa fa-copyright",attrs:{"aria-hidden":"true"}}),t._v("\n                2020-"+t._s(t.currentDate())+" "+t._s(t.companyinfo.company_name)+"-All Rights Reserved\n              ")])])]),t._v(" "),a("div",{staticClass:"col-xl-6 col-md-6 col-sm-12"},[a("div",{staticClass:"payment-card-bottom"},[a("ul",t._l(t.paymentitems,(function(e,i){return a("li",[a("a",{attrs:{href:"#"}},[a("img",{attrs:{src:t.imageSrc+e.logo,alt:""}})])])})),0)])])])])])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"footer-title footer-mobile-title"},[a("h4",[t._v("my account")])])}],!1,null,null,null).exports;var h=a(7249);function _(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const f={data:function(){return{swiperOption:{loop:!0,navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"}},sliderImageUrl:"",sliders:[]}},created:function(){this.getSliders()},methods:{getSliders:function(){var t,e=this;return(t=s().mark((function t(){var a,i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a={act_status:"1"},t.next=3,e.$root.getFrontData(a,"/api/slider_param");case 3:i=t.sent,e.sliderImageUrl=i.data.url,e.sliders=i.data.data;case 6:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){_(r,i,s,n,o,"next",t)}function o(t){_(r,i,s,n,o,"throw",t)}n(void 0)}))})()}}};const g=(0,l.Z)(f,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("section",{staticClass:"p-0 small-slider"},[a("div",{staticClass:"slide-1 home-slider"},[a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},t._l(t.sliders,(function(e){return a("div",{staticClass:"swiper-slide"},[a("div",{staticClass:"home text-left",style:{backgroundImage:"url("+t.sliderImageUrl+e.bg_img+")"}},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[a("div",{staticClass:"slider-contain"},[a("div",[a("h4",[t._v(t._s(e.title_text))]),t._v(" "),a("h1",[t._v(t._s(e.main_text))]),t._v(" "),a("router-link",{staticClass:"btn btn-solid",attrs:{to:{path:"/shop"},exact:""}},[t._v("shop now")])],1)])])])])])])})),0),t._v(" "),a("div",{staticClass:"swiper-button-prev",attrs:{slot:"button-prev"},slot:"button-prev"}),t._v(" "),a("div",{staticClass:"swiper-button-next",attrs:{slot:"button-next"},slot:"button-next"})])])])])}),[],!1,null,null,null).exports;function w(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const C={data:function(){return{swiperOption:{slidesPerView:6,freeMode:!0,checkAvailability:0,breakpoints:{1199:{slidesPerView:6},768:{slidesPerView:4},420:{slidesPerView:3},0:{slidesPerView:2}}},items:[],imageSrc:""}},created:function(){this.getLogos()},methods:{getLogos:function(){var t,e=this;return(t=s().mark((function t(){var a,i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a={act_status:"1"},t.next=3,e.$root.getFrontData(a,"/api/sponsor_param");case 3:i=t.sent,e.items=i.data.data,e.checkAvailability=i.data.count,e.imageSrc=i.data.url;case 7:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){w(r,i,s,n,o,"next",t)}function o(t){w(r,i,s,n,o,"throw",t)}n(void 0)}))})()}}};const b=(0,l.Z)(C,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return t.checkAvailability?a("div",[a("section",{staticClass:"section-b-space"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{staticClass:"slide-6 no-arrow"},[a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},t._l(t.items,(function(e,i){return a("div",{key:i,staticClass:"swiper-slide"},[a("div",[a("div",{staticClass:"logo-block text-center"},[a("a",{attrs:{href:e.link}},[a("img",{staticClass:"img-fluid",staticStyle:{width:"100%","max-height":"230px"},attrs:{src:t.imageSrc+e.logo,alt:e.name}})])])])])})),0)])])])])])])]):t._e()}),[],!1,null,null,null).exports;function y(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const k={data:function(){return{promotion:[],imageSrc:""}},created:function(){this.getAllPromotion()},methods:{getAllPromotion:function(){var t,e=this;return(t=s().mark((function t(){var a,i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a={status:1},t.next=3,e.$root.getFrontData(a,"/api/promotions_param");case 3:i=t.sent,e.promotion=i.data.data,e.imageSrc=i.data.url;case 6:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){y(r,i,s,n,o,"next",t)}function o(t){y(r,i,s,n,o,"throw",t)}n(void 0)}))})()}}};const x=(0,l.Z)(k,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("section",{staticClass:"pt-0 banner-6 pet-collection-banner ratio2_1"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row partition3"},t._l(t.promotion,(function(e,i){return a("div",{key:i,staticClass:"col-md-4"},[a("router-link",{attrs:{to:{path:"/collection/leftsidebar/all"}}},[a("div",{staticClass:"collection-banner p-left text-left"},[a("div",{staticClass:"img-part"},[a("img",{staticClass:"img-fluid",attrs:{src:t.imageSrc+e.image,alt:"banner"}})]),t._v(" "),a("div",{staticClass:"contain-banner banner-3"},[a("div",[a("h2",[t._v(t._s(e.name))])])])])])],1)})),0)])])])}),[],!1,null,null,null).exports;function S(t,e){var a="undefined"!=typeof Symbol&&t[Symbol.iterator]||t["@@iterator"];if(!a){if(Array.isArray(t)||(a=function(t,e){if(!t)return;if("string"==typeof t)return P(t,e);var a=Object.prototype.toString.call(t).slice(8,-1);"Object"===a&&t.constructor&&(a=t.constructor.name);if("Map"===a||"Set"===a)return Array.from(t);if("Arguments"===a||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(a))return P(t,e)}(t))||e&&t&&"number"==typeof t.length){a&&(t=a);var i=0,s=function(){};return{s,n:function(){return i>=t.length?{done:!0}:{done:!1,value:t[i++]}},e:function(t){throw t},f:s}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var r,n=!0,o=!1;return{s:function(){a=a.call(t)},n:function(){var t=a.next();return n=t.done,t},e:function(t){o=!0,r=t},f:function(){try{n||null==a.return||a.return()}finally{if(o)throw r}}}}function P(t,e){(null==e||e>t.length)&&(e=t.length);for(var a=0,i=new Array(e);a<e;a++)i[a]=t[a];return i}const $={props:["product","index","imageSrc"],data:function(){return{product__images:[],quickviewProduct:{},showquickview:!1}},watch:{product:function(){this.setProductImages()}},created:function(){this.setProductImages()},computed:{currency:function(){return this.$store.state.siteCurrency}},methods:{setProductImages:function(){var t=this,e=this.product,a=1;return this.product__images.splice(0),this.product__images.push({id:a,image:this.imageSrc+e.pd_thumbnail,isActive:!0}),e.productimages.forEach((function(e,i){t.product__images.push({id:++a,image:t.imageSrc+e.pro_img_name,isActive:!1})})),this.product__images},getActiveImage:function(){var t,e="",a=S(this.product__images);try{for(a.s();!(t=a.n()).done;){var i=t.value;if(i.isActive){e=i.image;break}}}catch(t){a.e(t)}finally{a.f()}return e},productVariantChange:function(t){var e,a=S(this.product__images);try{for(a.s();!(e=a.n()).done;){e.value.isActive=!1}}catch(t){a.e(t)}finally{a.f()}var i,s=S(this.product__images);try{for(s.s();!(i=s.n()).done;){var r=i.value;r.id===t&&(r.isActive=!0)}}catch(t){s.e(t)}finally{s.f()}},addToWishlist:function(t){var e={pd_id:t,session_id:JSON.parse(sessionStorage.getItem("session_id")).id};this.$root.getFrontData(e,"/api/wishlist").then((function(t){Vue.$toast.open({message:t.data.message,position:"top-right",type:"success",duration:3e3,dismissible:!1})})).catch((function(t){Vue.$toast.open({message:"Product Is not added to your wishlist.",position:"top-right",type:"error",duration:3e3,dismissible:!1})}))},addItemToCart:function(t){var e={pd_id:t,session_id:JSON.parse(sessionStorage.getItem("session_id")).id,ct_qty:1};this.$store.dispatch("addToCart",e)},addToCompare:function(t){var e={pd_id:t,session_id:JSON.parse(sessionStorage.getItem("session_id")).id};this.$root.getFrontData(e,"/api/compare").then((function(t){Vue.$toast.open({message:t.data.message,position:"top-right",type:"success",duration:3e3,dismissible:!1})})).catch((function(t){Vue.$toast.open({message:"Product Is successfully added to your Compare list.",position:"top-right",type:"error",duration:3e3,dismissible:!1})}))},showQuickview:function(t){this.showquickview=!0,this.quickviewProduct=t,this.$emit("openquickview",this.showquickview,this.quickviewProduct)}}};const I=(0,l.Z)($,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"img-wrapper"},[a("div",{staticClass:"lable-block"},[t.product.new_stat?a("span",{staticClass:"lable3"},[t._v("new")]):t._e(),t._v(" "),t.product.onsale_stat?a("span",{staticClass:"lable4"},[t._v("on sale")]):t._e()]),t._v(" "),a("div",{staticClass:"front"},[a("router-link",{attrs:{to:{name:"productdetails",params:{pdname:t.product.pd_name.replace(/\s+/g,"-").toLowerCase(),id:t.product.id}}}},[a("img",{key:t.index,staticClass:"img-fluid bg-img",attrs:{src:t.getActiveImage(),id:t.product.id,alt:t.product.title}})])],1),t._v(" "),a("div",{staticClass:"cart-info cart-wrap"},[a("a",{attrs:{href:"javascript:void(0)",title:"Add to cart"}},[a("i",{staticClass:"ti-shopping-cart",attrs:{"aria-hidden":"true"},on:{click:function(e){return t.addItemToCart(t.product.id)}}})]),t._v(" "),a("a",{attrs:{href:"javascript:void(0)",title:"Wishlist"}},[a("i",{staticClass:"ti-heart",attrs:{"aria-hidden":"true"},on:{click:function(e){return t.addToWishlist(t.product.id)}}})]),t._v(" "),a("a",{attrs:{href:"javascript:void(0)",title:"Quick View",variant:"primary"},on:{click:function(e){return t.showQuickview(t.product)}}},[a("i",{staticClass:"ti-search",attrs:{"aria-hidden":"true"}})]),t._v(" "),a("a",{attrs:{href:"javascript:void(0)",title:"Compare"}},[a("i",{staticClass:"ti-reload",attrs:{"aria-hidden":"true"},on:{click:function(e){return t.addToCompare(t.product.id)}}})])])]),t._v(" "),a("div",{staticClass:"product-detail"},[t._m(0),t._v(" "),a("router-link",{attrs:{to:{name:"productdetails",params:{pdname:t.product.pd_name.replace(/\s+/g,"-").toLowerCase(),id:t.product.id}}}},[a("h6",[t._v(t._s(t.product.pd_name))])]),t._v(" "),a("p",[t._v(t._s(t.product.product_detail))]),t._v(" "),t.product.onsale_stat?a("h4",[t._v("\n\t\t\t\t"+t._s(t.currency+t.product.pd_price)+"\n\t\t\t\t"),a("del",[t._v(t._s(t.currency+t.product.pd_prev_price))])]):a("h4",[t._v(t._s(t.currency+t.product.pd_price))])],1)])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"rating"},[a("i",{staticClass:"fa fa-star"}),t._v(" "),a("i",{staticClass:"fa fa-star"}),t._v(" "),a("i",{staticClass:"fa fa-star"}),t._v(" "),a("i",{staticClass:"fa fa-star"}),t._v(" "),a("i",{staticClass:"fa fa-star"})])}],!1,null,null,null).exports,D={props:["products","imageSrc"],components:{productBox5:I},data:function(){return{title:"top collection",subtitle:"special offer",showquickviewmodel:!1,quickviewproduct:{},description:"",swiperOption:{slidesPerView:4,spaceBetween:20,freeMode:!1,breakpoints:{1199:{slidesPerView:4,spaceBetween:20},991:{slidesPerView:3,spaceBetween:20},420:{slidesPerView:1,spaceBetween:20},0:{slidesPerView:1,spaceBetween:20}}}}},computed:{},created:function(){},mounted:function(){},methods:{showquickview:function(t,e){this.showquickviewmodel=t,this.quickviewproduct=e,this.$emit("openQuickview",this.showquickviewmodel,this.quickviewproduct)}}};const q=(0,l.Z)(D,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("section",{staticClass:"section-b-space j-box pets-box ratio_square"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[a("div",{staticClass:"title1 title5"},[a("h4",[t._v(t._s(t.subtitle))]),t._v(" "),a("h2",{staticClass:"title-inner1"},[t._v(t._s(t.title))]),t._v(" "),a("hr",{attrs:{role:"tournament6"}})]),t._v(" "),a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},t._l(t.products,(function(e,i){return a("div",{key:i,staticClass:"swiper-slide"},[a("div",{staticClass:"product-box"},[a("productBox5",{attrs:{product:e,index:i,"image-src":t.imageSrc},on:{openquickview:t.showquickview}})],1)])})),0)])])])])])])}),[],!1,null,null,null).exports;function A(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const V={data:function(){return{bannerImageUrl:"",banner:{},checkAvailability:0}},created:function(){this.getBanner()},methods:{getBanner:function(){var t,e=this;return(t=s().mark((function t(){var a,i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a={active_status:"1"},t.next=3,e.$root.getFrontData(a,"/api/sliderbackground_param");case 3:i=t.sent,e.checkAvailability=i.data.count,e.bannerImageUrl=i.data.url,e.banner=i.data.data[0];case 7:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){A(r,i,s,n,o,"next",t)}function o(t){A(r,i,s,n,o,"throw",t)}n(void 0)}))})()}}};const B=(0,l.Z)(V,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[t.checkAvailability?a("section",{staticClass:"p-0 pet-parallax"},[a("div",{staticClass:"full-banner parallax text-center p-center",style:{backgroundImage:"url("+t.bannerImageUrl+t.banner.image+")"}},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[a("div",{staticClass:"banner-contain"},[a("h2",[t._v(t._s(t.banner.main_text))]),t._v(" "),a("h3",[t._v(t._s(t.banner.second_text))]),t._v(" "),a("h4",[t._v(t._s(t.banner.additional_text))]),t._v(" "),a("a",{staticClass:"btn btn-solid black-btn",attrs:{href:"#",tabindex:"0"}},[t._v("shop now")])])])])])])]):t._e()])}),[],!1,null,null,null).exports;const E={props:["products","imageSrc"],components:{productBox5:I},data:function(){return{title:"top collection",subtitle:"special offer",showquickviewmodel:!1,quickviewproduct:{},description:"",swiperOption:{slidesPerView:4,spaceBetween:20,freeMode:!1,breakpoints:{1199:{slidesPerView:4,spaceBetween:20},991:{slidesPerView:3,spaceBetween:20},420:{slidesPerView:1,spaceBetween:20},0:{slidesPerView:1,spaceBetween:20}}}}},computed:{},created:function(){},mounted:function(){},methods:{showquickview:function(t,e){this.showquickviewmodel=t,this.quickviewproduct=e,this.$emit("openQuickview",this.showquickviewmodel,this.quickviewproduct)}}};const O=(0,l.Z)(E,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("section",{staticClass:"section-b-space j-box pets-box ratio_square"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[a("div",{staticClass:"title1 title5"},[a("h4",[t._v(t._s(t.subtitle))]),t._v(" "),a("h2",{staticClass:"title-inner1"},[t._v(t._s(t.title))]),t._v(" "),a("hr",{attrs:{role:"tournament6"}})]),t._v(" "),a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},t._l(t.products,(function(e,i){return a("div",{key:i,staticClass:"swiper-slide"},[a("div",{staticClass:"product-box"},[a("productBox5",{attrs:{product:e,index:i,"image-src":t.imageSrc},on:{openquickview:t.showquickview}})],1)])})),0)])])])])])])}),[],!1,null,null,null).exports;function L(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}const T={data:function(){return{title:"from the blog",imageSrc:"",bloglist:[],subtitle:"recent story",checkAvailability:0,swiperOption:{slidesPerView:3,spaceBetween:20,freeMode:!0,breakpoints:{1199:{slidesPerView:3,spaceBetween:20},991:{slidesPerView:3,spaceBetween:20},420:{slidesPerView:2,spaceBetween:20},0:{slidesPerView:1,spaceBetween:20}}}}},computed:{},created:function(){this.getBlogs()},methods:{published__date:function(t){var e=new Date(t),a=e.getDate(),i=e.toLocaleString("default",{month:"short"}),s=e.getFullYear();return"".concat(i," ").concat(a,", ").concat(s)},getBlogs:function(){var t,e=this;return(t=s().mark((function t(){var a,i;return s().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return a={news_status:"1"},t.next=3,e.$root.getFrontData(a,"/api/news_param");case 3:i=t.sent,e.bloglist=i.data.data,e.checkAvailability=i.data.count,e.imageSrc=i.data.url;case 7:case"end":return t.stop()}}),t)})),function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){L(r,i,s,n,o,"next",t)}function o(t){L(r,i,s,n,o,"throw",t)}n(void 0)}))})()}}};var Z=(0,l.Z)(T,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return t.checkAvailability?a("div",[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col"},[a("div",{staticClass:"title1 title5"},[a("h4",[t._v(t._s(t.subtitle))]),t._v(" "),a("h2",{staticClass:"title-inner1"},[t._v(t._s(t.title))]),t._v(" "),a("hr",{attrs:{role:"tournament6"}})])])])]),t._v(" "),a("section",{staticClass:"section-b-space blog p-t-0 blog_box ratio2_3"},[a("div",{staticClass:"container"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-12"},[a("div",{directives:[{name:"swiper",rawName:"v-swiper:mySwiper",value:t.swiperOption,expression:"swiperOption",arg:"mySwiper"}]},[a("div",{staticClass:"swiper-wrapper"},t._l(t.bloglist,(function(e,i){return a("div",{key:i,staticClass:"swiper-slide"},[a("router-link",{attrs:{to:{name:"blogdetails",params:{blogId:e.id}}}},[a("div",{staticClass:"classic-effect"},[a("div",[a("img",{staticClass:"img-fluid",staticStyle:{width:"100%","max-height":"230px"},attrs:{src:t.imageSrc+e.news_image,alt:""}})]),t._v(" "),a("span")])]),t._v(" "),a("div",{staticClass:"blog-details"},[a("h4",[t._v(t._s(t.published__date(e.created_at)))]),t._v(" "),a("router-link",{attrs:{to:{name:"blogdetails",params:{blogId:e.id}}}},[a("p",[t._v(t._s(e.news_title))])]),t._v(" "),a("hr",{staticClass:"style1"}),t._v(" "),a("h6",[t._v("by: Nextech , 2 Comment")])],1)],1)})),0)])])])])])]):t._e()}),[],!1,null,null,null);function F(t,e,a,i,s,r,n){try{var o=t[r](n),c=o.value}catch(t){return void a(t)}o.done?e(c):Promise.resolve(c).then(i,s)}function N(t){return function(){var e=this,a=arguments;return new Promise((function(i,s){var r=t.apply(e,a);function n(t){F(r,i,s,n,o,"next",t)}function o(t){F(r,i,s,n,o,"throw",t)}n(void 0)}))}}const z={components:{Header:u,Slider:g,LogoSlider:b,Collectionbanner:x,TopCollection:q,Banner:B,ProductSlider:O,Blog:Z.exports,Footer:m,quickviewModel:h.Z},data:function(){return{tabCategory:[{name:"Featured",value:"4"},{name:"Popular",value:"1"},{name:"New",value:"3"},{name:"On Sale",value:"5"}],sliderProducts:[],meta:{},imageSrc:"",showquickviewmodel:!1,quickviewproduct:{}}},created:function(){this.getProductSliderProducts()},methods:{getMeta:function(){var t=this;return N(s().mark((function e(){var a,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a={meta_page:"home",status:"1"},e.next=3,t.$root.getFrontData(a,"/api/meta/param");case 3:i=e.sent,t.meta=i.data.data[0];case 5:case"end":return e.stop()}}),e)})))()},getProductSliderProducts:function(){var t=this;return N(s().mark((function e(){var a,i;return s().wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return a={"tag[]":"2"},e.next=3,t.$root.getFrontData(a,"/api/product_param?page=1&limit=8");case 3:i=e.sent,t.sliderProducts=i.data.data.data,t.imageSrc=i.data.url;case 6:case"end":return e.stop()}}),e)})))()},showQuickview:function(t,e){this.showquickviewmodel=t,this.quickviewproduct=e}},mounted:function(){},metaInfo:function(){return{title:this.meta.meta_name,meta:[{name:"description",content:this.meta.meta_content},{name:"keywords",content:this.meta.meta_type},{property:"og:title",content:this.meta.meta_content},{property:"og:site_name",content:this.meta.meta_name},{property:"og:type",content:"website"},{name:"robots",content:"index,follow"}]}}};const M=(0,l.Z)(z,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("Header"),t._v(" "),a("Slider"),t._v(" "),a("LogoSlider"),t._v(" "),a("Collectionbanner"),t._v(" "),a("TopCollection",{attrs:{products:t.sliderProducts,"image-src":t.imageSrc},on:{openQuickview:t.showQuickview}}),t._v(" "),a("Banner"),t._v(" "),a("ProductSlider",{attrs:{products:t.sliderProducts,"image-src":t.imageSrc},on:{openQuickview:t.showQuickview}}),t._v(" "),a("Blog"),t._v(" "),a("Footer"),t._v(" "),a("quickviewModel",{attrs:{openModal:t.showquickviewmodel,productData:t.quickviewproduct,"image-src":t.imageSrc}})],1)}),[],!1,null,null,null).exports}}]);
//# sourceMappingURL=923.js.map