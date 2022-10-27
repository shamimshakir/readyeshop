<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Add product Filter" btnRoute="productfilter" btnName="Product Filter" />
        <div class="card-body">
            <form @submit.prevent="addproductfilters($event)">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !productfilters.name
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="productfilters.name" placeholder="Name" />
                            <p class="text-danger" v-if="
                                errors.name.length > 0 && !productfilters.name
                            " v-for="name in errors.name">
                                {{ name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Others Name <span class="text-danger">*</span></label>
                            <input type="text" :class="
                            !isEmpty(errors) && !productfilters.others_lan
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="productfilters.others_lan" placeholder="Others Name" />
                            <p class="text-danger" v-if="
                                errors.others_lan.length > 0 && !productfilters.others_lan
                            " v-for="others_lan in errors.others_lan">
                                {{ others_lan }}
                            </p>
                        </div>
                    </div>                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select :class="
                            !isEmpty(errors) && !productfilters.status
                            ? 'form-control border-danger'
                            : 'form-control'
                        " v-model="productfilters.status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                            <p class="text-danger" v-if="
                                errors.status.length > 0 && !productfilters.status
                            " v-for="status in errors.status">
                                {{ status }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border border-primary">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Add Option (for this Filter)</span>
                                <button type="button" @click="addOptionRow()" class="btn btn-sm btn-info float-right">
                                    Add row
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row" v-for="(allOption, index) in allOptions" :key="allOption.id">
                                    <div class="col-lg-1 pr0 pl0">
                                        <div class="form-group"> 
                                            <i class="far fa-trash-alt red" @click="deleteRow(allOption.id, allOption)"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 pr0 pl0">
                                        <div class="form-group">                                           
                                            <input type="text" class="form-control" v-model="allOption.option_name" placeholder="Name" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pr0 pl0">
                                        <div class="form-group">                                            
                                            <input type="text" class="form-control" v-model="allOption.others_option_name" placeholder="Others Name" />
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
                <button type="submit" class="btn btn-primary">Create product filter</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
// jQuery

import CardHeader from "../basics/CardHeader";
export default {
    components: {
        CardHeader,
    },
    data() {
        return {
            productfilters: {
                status: "",
            },
            errors: [],
            allOptions: [{
                id: 1,
                option_name:"",
                others_option_name:"",
            }],
        }
    },
    created() {
    },
    methods: {
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        addOptionRow() {
            let obj = {
                id: new Date().getUTCMilliseconds(),
                option_name:"",
                others_option_name:"",
            };
            this.allOptions.push(obj);
        },
        deleteRow(index, invoice_product) {
            var idx = this.allOptions.indexOf(invoice_product);
            console.log(idx, index);
            if (idx > -1) {
                this.allOptions.splice(idx, 1);
            }           
        },
        addproductfilters(event) {
            this.productfilters['all_options'] = this.allOptions;          
            this.$root.addData(this.productfilters, '/api/user/productFilter').then(response => {
                //console.dir(response)
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "productfilter",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to Add productfilters",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        },
    }
}
</script>
<style>
    .red{
        color:red;
    }
    .pl0{
        padding-left: 0px;
    }
    .pr0{
        padding-right: 0px;
    }
</style>   
