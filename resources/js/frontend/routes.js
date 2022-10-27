
const routes = [
    { path: '/category/:catname', name: 'category', component: () => import(/* webpackChunkName: "category" */ './pages/Category')},
    { path: '/product/details/:pdname', name: 'productdetails', component: () => import(/* webpackChunkName: "productdetails" */ './pages/Product') },
    { path: '/about', name: 'about', component: () => import(/* webpackChunkName: "about" */ './pages/About') },
    { path: '/contact', name: 'contact', component: () => import(/* webpackChunkName: "contact" */ './pages/Contact') },
    { path: '/faq', name: 'faq', component: () => import(/* webpackChunkName: "faq" */ './pages/FAQ') },
    { path: '/shop', name: 'shop', component: () => import(/* webpackChunkName: "shop" */ './pages/Shop') },
    { path: '/checkout', name: 'checkout', component: () => import(/* webpackChunkName: "checkout" */ './pages/Checkout') },
    { path: '/cart', name: 'cart', component: () => import(/* webpackChunkName: "cart" */ './pages/Cart') },
    { path: '/account/dashboard', name: 'dashboard', component: () => import(/* webpackChunkName: "dashboard" */ './pages/Dashboard') },
    { path: '/account/register', name: 'register', component: () => import(/* webpackChunkName: "register" */ './pages/Register') },
    { path: '/account/login', name: 'login', component: () => import(/* webpackChunkName: "login" */ './pages/Login') },
    { path: '/account/wishlist', name: 'wishlist', component: () => import(/* webpackChunkName: "wishlist" */ './pages/WishList') },
    { path: '/account/compare', name: 'compare', component: () => import(/* webpackChunkName: "compare" */ './pages/Compare') },
    { path: '/account/profile', name: 'profile', component: () => import(/* webpackChunkName: "profile" */ './pages/Profile') },
    { path: '/others/:pagename', name: 'others', component: () => import(/* webpackChunkName: "others" */ './pages/Others') },
    { path: '/order-success', name: 'ordersuccess', component: () => import(/* webpackChunkName: "ordersuccess" */ './partials/page/order-success.vue') },
    { path: '/blog/details', name: 'blogdetails', component: () => import(/* webpackChunkName: "blogdetails" */ './partials/blog/blog-detail.vue') },
    { path: '/ordertrack/:orderno', name: 'ordertrack', component: () => import(/* webpackChunkName: "ordertrack" */ './pages/Ordertrack') },

    { path: '/auth/:provider/callback', name: 'sociallogin', component: {
      template: '<div class="auth-component"></div>'
    } },
];

export default routes;