window.Vue = require('vue').default;

import axios from 'axios';
import Vue from 'vue';
import VueAxios from 'vue-axios';
import ToggleButton from 'vue-js-toggle-button';
import VueLoaders from 'vue-loaders';
import 'vue-loaders/dist/vue-loaders.css';
import VuePageTransition from 'vue-page-transition';
import VueRouter from 'vue-router';
import RouterTab from 'vue-router-tab';
import 'vue-router-tab/dist/lib/vue-router-tab.css';
import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';
import VueSimpleAlert from "vue-simple-alert";
import tinymce from 'vue-tinymce-editor';
import { VuejsDatatableFactory } from 'vuejs-datatable';
import App from './App.vue';
import frontMixins from './mixins';
import { routes } from './routes';
import store from './store';

Vue.use(VueSidebarMenu)


Vue.use(RouterTab);

Vue.use(ToggleButton);
Vue.use(VueSimpleAlert);
 
Vue.use( VuejsDatatableFactory );

Vue.use(VueLoaders);
Vue.use(VuePageTransition);

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.component('tinymce', tinymce)


const router = new VueRouter({
    mode: 'hash',
    routes: routes,
    linkExactActiveClass: "active"
});

const app = new Vue({
    el: '#wrapper',
    data: { },
    router: router,
    mixins: [frontMixins],
    store,
    render: h => h(App),
});


