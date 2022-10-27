import axios from 'axios';
import Vue from 'vue';
import VueAxios from 'vue-axios';
import VueToast from 'vue-toast-notification';
import Vuex from 'vuex';
Vue.use(VueAxios, axios);
Vue.use(VueToast);
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
      token: null,
      isLogin: false,
      siteCurrency: "৳",
      hostBase: null,
      cartItemInfo: [],
      companyInfo:{},
      companyImg:null,
      leftSidebarVal: false,
      rightSidebarVal: false,
    },
    getters: {
        cartItemCount(state){
          return state.cartItemInfo.count;
        },
        cartProducts(state){
          return state.cartItemInfo.data;
        },
        cartTotal(state){
          return state.cartItemInfo.total;
        },
        cartImgSrc(state){
          return state.cartItemInfo.url;
        },
        companyinfo(state){          
          return state.companyInfo;
        },
        companyImg(state){          
          return state.companyImg;
        },
    },
    actions: {
      getCartItems({ commit, state }){
        let session_id = JSON.parse(sessionStorage.getItem("session_id"));
        let sessionId = session_id.id;
        let dataObj = {
            'session_id': sessionId,
        }
        var qs = require("qs");
        var data = qs.stringify(dataObj);
        var config = {
          method: "post",
          url: state.hostBase + "/api/cart/show",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          data: data,
        };
        axios(config)
          .then((response) => {
            commit('SET_CART_ITEMS', response.data);
          })
          .catch((error) => {
            console.dir(error)
          });
      },
      addToCart({ dispatch, state }, dataObj){
        var qs = require("qs");
        var data = qs.stringify(dataObj);
        var config = {
          method: 'post',
          url: state.hostBase + "/api/cart",
          headers: { 
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          data : data
        };
        axios(config)
          .then((response) => {
            Vue.$toast.open({
                message:  response.data.message,
                position: 'top-right',
                type: 'success',
                duration: 3000,
                dismissible: false,
            });
            dispatch('getCartItems');
          })
          .catch((error) => {
            Vue.$toast.open({
                message: "Product Is not added to your cart.",
                position: 'top-right',
                type: 'error',
                duration: 3000,
                dismissible: false,
            })
          });
      },
      removeCart({ dispatch, state }, cId){
        let session_id = JSON.parse(sessionStorage.getItem("session_id"));
        let sessionId = session_id.id;
        let dataObj = {
          session_id: sessionId,
          id: cId,
        };
        var qs = require("qs");
        var data = qs.stringify(dataObj);
        var config = {
          method: 'post',
          url: state.hostBase + "/api/cart/delete",
          headers: { 
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          data : data
        };
        axios(config)
          .then((response) => {
            dispatch('getCartItems');
          })
          .catch((error) => {
            console.dir(error)
          });
      },
      clearCart({ dispatch, state }){
        let session_id = JSON.parse(sessionStorage.getItem("session_id"));
        let sessionId = session_id.id;
        let dataObj = {
          session_id: sessionId,
        };
        var qs = require("qs");
        var data = qs.stringify(dataObj);
        var config = {
          method: 'post',
          url: state.hostBase + "/api/cart/delete",
          headers: { 
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          data : data
        };
        axios(config)
          .then((response) => {
            dispatch('getCartItems');
          })
          .catch((error) => {
            console.dir(error)
          });
      },
      updateCart({ dispatch, state }, dataObj){
        var qs = require("qs");
        var data = qs.stringify(dataObj);
          var config = {
            method: 'put',
            url: state.hostBase + '/api/cart/update',
            headers: { 
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            data : data
          };
          axios(config)
          .then(function (response) {
            dispatch('getCartItems');
          })
          .catch(function (error) {
            console.dir(error);
          });
      },
      getCompanyInfos({ commit, state }){        
        var qs = require("qs");
        var data = qs.stringify({});
        var config = {
          method: "post",
          url: state.hostBase + "/api/company_param",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          data: data,
        };
        axios(config)
          .then((response) => {
            commit('SET_COMPANY_ITEMS', response.data.data[0]);
            commit('SET_COMPANY_IMG', response.data.url);
          })
          .catch((error) => {
            console.dir(error)
          });
      },
    }, 
    mutations: {
      SET_CART_ITEMS(state, items){
        state.cartItemInfo = items;
      },
      SET_COMPANY_ITEMS(state, items){
        state.companyInfo = items;
      },
      SET_COMPANY_IMG(state, items){
        state.companyImg = items;
      },
      SET_HOST_NAME(state, uri){
        state.hostBase = uri;
      },
      UPDATE_TOKEN_FROM_LOGIN(state, loginToken) {
          state.token = loginToken;
      },
      UPDATE_ISLOGIN(state, value) {
          state.isLogin = value;
      },
      CHANGE_LEFT_SIDEBAR(state, value){
        state.leftSidebarVal = value;
      },
      CHANGE_RIGHT_SIDEBAR(state, value){
        state.rightSidebarVal = value;
      }
    },
})