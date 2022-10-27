import axios from 'axios';
import Vue from 'vue';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

const frontMixins = {
    methods: {
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
      getDetailsData(formdata={} , url){
         var qs = require("qs");
         var data = qs.stringify(formdata);       
         var config = {
            method: "post",
            url: this.$store.state.hostBase + url,
            headers: {
               Authorization: `Bearer ${this.$store.state.token}`
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
      }
  }
}
export default frontMixins;