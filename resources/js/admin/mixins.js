import axios from 'axios';
import Vue from 'vue';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

const myMixins = {
    methods: {
      getOnlyDateFrom(dateTime){
          let dateObj = new Date(dateTime);
          return {'yr': dateObj.getFullYear(), 'mn': dateObj.getMonth()+1, 'dt': dateObj.getDate()}
      },
      getAllData: function (url) {
        var config = {
          method: "get",
          url: this.$store.state.hostBase + url,
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        };
        return axios(config)
          .then((response) => {
            return response.data.data;
          })
          .catch(function (error) {
            return error;
          });
      },
      getAllDataWithImages: function (url) {
        let products = [];
        var config = {
          method: "get",
          url: this.$store.state.hostBase + url,
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json'
          },
        };
        return axios(config)
          .then((response) => {
            products.push(response.data);
            return products;
          })
          .catch(function (error) {
            return error;
          });
      },
      addData(formdata, url){
        var qs = require("qs");
        var data = qs.stringify(formdata);
        var config = {
          method: "post",
          url: this.$store.state.hostBase + url,
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
            "Content-Type": "application/x-www-form-urlencoded",
          },
          data: data,
        };
        return new Promise((resolve, reject) => {
          this.axios(config)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => {
            reject(error)
          });
        })
      },
      updateData(formdata, url){
        var qs = require("qs");
        var data = qs.stringify(formdata);
        var config = {
          method: "put",
          url: this.$store.state.hostBase + url,
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
            "Content-Type": "application/x-www-form-urlencoded",
          },
          data: data,
        };
        return new Promise((resolve, reject) => {
          this.axios(config)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => {
            reject(error)
          });
        })
      },
      getFrontData(formdata, url){
        var qs = require("qs");
        var data = qs.stringify(formdata);
        var config = {
          method: "post",
          url: this.$store.state.hostBase + url,
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          data: data,
        };
        return new Promise((resolve, reject) => {
          this.axios(config)
          .then((response) => {
            resolve(response);
          })
          .catch((error) => {
            reject(error)
          });
        })
      },

    },
};
export default myMixins;