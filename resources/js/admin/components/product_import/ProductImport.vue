<template> 
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-header d-flex justify-content-between align-items-center font-16 mt-0">
            <strong class="text-primary">Product Import</strong>
            <span>
                <a href="product_imports.xlsx" class="btn btn-primary btn-sm" download="">Sample File <i class="fa fa-download" aria-hidden="true"></i></a>              
            </span>
          

        </div>       
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">                 
                  <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"   @change="onFileChange">                 
                </div> 
                <div class="col-md-2">                    
                    <button class="btn btn-success btn-sm" @click="proceedAction" type="button"> Import Data</button> 
                </div>
                <div class="col-md-2">                    
                    <button class="btn btn-warning btn-sm" @click="synall" type="button"> Syn All Data</button> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div v-if="error.message" class="invalid-feedback">
                
                    </div>
                </div> 
            </div>
            <br>
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th  class="text-center">Action</th>
                        <th>
                            <label class="form-checkbox">
                            <input type="checkbox" v-model="selectAll" @click="select">
                             <i class="form-icon"></i>
                            </label>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sProduct in productImports" :key="sProduct.id">
                        <td>{{ sProduct.id }}</td>
                        <td>{{ sProduct.product_name }}</td>
                        <td>{{ sProduct.category }}</td>
                        <td>{{ sProduct.brand }}</td>
                        <td>{{ sProduct.price }}</td>
                        <td>{{ sProduct.qty }}</td>
                        <td>{{ sProduct.img }}</td>
                        <td>{{ sProduct.highlight }}</td>
                        <td class="text-center">
                            <router-link :to="{name: 'productImportEdit', params: { id: sProduct.id }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></router-link>
                            <button class="btn btn-success btn-sm" type="button" @click="syndata(sProduct.id)"><i class="fas fa-sync"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" @click="deleteproduct(sProduct.id)"><i class="fas fa-trash-alt"></i></button>
                        </td>                        
                         <td>
                            <label class="form-checkbox">
                                <input type="checkbox" :value="sProduct.id" @click="unselect" v-model="selected">
                                <i class="form-icon"></i>
                            </label>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
</template> 
<script>
import CardHeader from "../basics/CardHeader";
import StatusBadge from "../basics/StatusBadge";

import axios from 'axios';
import Vue from 'vue';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

export default {
 data() {
    return {
      error: {},
      productImports: [],
      import_file: '',
      selected: [],
      selectAll: false
    }
  },
  computed: {
        
    },
  created() {
    this.getProducts();
  },
  
  methods: {

    onFileChange(e) {
        this.import_file = e.target.files[0];
    },

    proceedAction() {
    let formData = new FormData();
    formData.append('import_file', this.import_file);
      axios.post(this.$store.state.hostBase +'/api/user/productimport/import', formData, {
          headers: { Authorization: `Bearer ${this.$store.state.token}`,
                    'content-type': 'multipart/form-data' }
        })
        .then(response => {
            console.dir(response)
            if(response.status === 200) {
              this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
              this.getProducts();
            }
        })
        .catch(error => {
            console.dir(error)
            // code here when an upload is not valid
            this.uploading = false
            this.error = error.response.data
            console.dir('check error: ', this.error)
        });
    },
    async getProducts() {
        this.loading = true;
        let data = await this.$root.getAllDataWithImages('/api/user/productimport');
        
        this.productImports = data[0].data;
        this.loading = false;
    },
    syndata(id){
        let data={
            'id':id
            }
        this.loading = true;
        this.$root.addData(data, '/api/user/productimport/synproduct').then(response => {           
            this.$fire({
                title: response.data.message,
                type: "success",
                timer: 2000
            });
            this.getProducts();
            this.loading = false;           
        }).catch(error => {
            console.log(error.response.data.message);
            //console.dir(response.data.message);
            //let res = JSON.parse(error.response.data.message);
            //console.log(res);
            this.$fire({
                title: error.response.data.message,
                type: "warning",
                timer: 2000
            });
            this.loading = false;
        });
    },
    deleteproduct(id){
        let data={
            'id':id
            }
        this.loading = true;
        this.$root.addData(data, '/api/user/productimport/deleteProduct').then(response => {
            
            this.$fire({
                title: response.data.message,
                type: "success",
                timer: 2000
            });
            this.getProducts();
            this.loading = false;
           
        }).catch(error => {
            console.log(error.response.data.message);
            //console.dir(response.data.message);
            //let res = JSON.parse(error.response.data.message);
            //console.log(res);
            this.$fire({
                title: error.response.data.message,
                type: "warning",
                timer: 2000
            });
            this.loading = false;

        });
    },
    select() {
        this.selected = [];
        if (!this.selectAll) {
            for (let i in this.productImports) {
                this.selected.push(this.productImports[i].id);
            }
        }
    },
    unselect() {
            this.selectAll = false;
     }, 
    synall() {
            var form = new FormData();
            this.selected.forEach((id) => { 
                form.append('ids[]', id);
            });
            this.axios
                .post(`${this.$store.state.hostBase}/api/user/productimport/synproductbulk`, form, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    //console.dir(response);          
                    this.$fire({
                        title: response.data.message,
                        type: "success",
                        timer: 2000
                    });
                     this.loading = false;
                    this.getProducts();
                })
                .catch((error) => {
                    //console.dir(error);
                    //console.dir(response.data.message);
                    //let res = JSON.parse(error.response.data.message);
                    //console.log(res);
                    this.$fire({
                        title: error.response.data.message,
                        type: "warning",
                        timer: 2000
                    });
                    this.loading = false;
                });
        },
  }
}
</script>