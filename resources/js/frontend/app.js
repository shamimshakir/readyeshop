window.Vue = require('vue').default;

import axios from 'axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Vue from 'vue';
import 'swiper/css/swiper.css';
import VueAwesomeSwiper from 'vue-awesome-swiper';
import VueAxios from 'vue-axios';
import VueLoaders from 'vue-loaders';
import 'vue-loaders/dist/vue-loaders.css';
import Meta from 'vue-meta';
import VueRouter from 'vue-router';
import 'vue-router-tab/dist/lib/vue-router-tab.css';

import VueSocialSharing from 'vue-social-sharing';
import VueToast from 'vue-toast-notification';
import VueMeta from 'vue-meta'
import 'vue-toast-notification/dist/theme-sugar.css';
import myMixins from '../frontend/mixins';
import App from './App.vue';
import routes from './routes';
import store from './store';


Vue.use(Meta);

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueToast);
Vue.use(VueLoaders);
Vue.use(VueAwesomeSwiper)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueSocialSharing);
Vue.use(VueMeta)


store.commit("SET_HOST_NAME", window.location.origin);
async function getThemeName(){
  return new Promise((resolve) => {
    axios({
      method: 'post',
      url: `${store.state.hostBase}/api/company_param`,
    }).then(function (res) {
      resolve(res.data.data[0].themes.theme_name);
    })
  });
}
let router = null;
let app = null;
getThemeName().then(res => {
  routes.push({ path: '/', name: 'home', component: () => import(`./partials/shop/${res}/index.vue`) });
  router = new VueRouter({
      mode: 'history',
      routes: routes,
      linkExactActiveClass: "active"
  });
  app = new Vue({
      el: '#wrapper',
      data: { },
      router: router,
      mixins: [myMixins],
      store,
      render: h => h(App),
  });
});
