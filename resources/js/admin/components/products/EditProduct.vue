<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Product" btnRoute="products" btnName="Products" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateProduct($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_name">Product Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="productInput.pd_name" placeholder="Product Name" :class="checkError('pd_name')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " />
                            <p class="text-danger" v-if="checkError('pd_name')" v-for="pd_name in errors.pd_name">
                                {{ pd_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Category <span class="text-danger">*</span></label>
                            <select :class="
                                checkError('category_id')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="productInput.category_id">
                                <option disabled value="">Select Category</option>
                                <option v-for="category in categories" :value="category.id" :key="category.id">
                                    {{ category.cat_name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('category_id')" v-for="category_id in errors.category_id">
                                {{ category_id }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Brand</label>
                            <select class="form-control" v-model="productInput.brand_id">
                                <option disabled value="">Select Brand</option>
                                <option v-for="brand in brands" :value="brand.id" :key="brand.id">
                                    {{ brand.brand_display }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_price">Sell Price <span class="text-danger">*</span></label>
                            <input type="number" :class="checkError('pd_price')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productInput.pd_price" placeholder="Sell Price" min="1" />
                            <p class="text-danger" v-if="checkError('pd_price')" v-for="pd_price in errors.pd_price">
                                {{ pd_price }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_prev_price">Prvious Price</label>
                            <input type="number" :class="checkError('pd_prev_price')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productInput.pd_prev_price" placeholder="Prvious Price"  />
                            <p class="text-danger" v-if="checkError('pd_prev_price')" v-for="pd_prev_price in errors.pd_prev_price">
                                {{ pd_prev_price }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="hst">VAT (%)</label>
                            <input type="number" :class="checkError('hst')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productInput.hst" placeholder="VAT" />
                            <p class="text-danger" v-if="checkError('hst')" v-for="hst in errors.hst">
                                {{ hst }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_qty">Store Quantiy</label>
                            <input type="number" :class="checkError('pd_qty')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productInput.pd_qty" placeholder="Store Quantiy" min="0" />
                            <p class="text-danger" v-if="checkError('pd_qty')" v-for="pd_qty in errors.pd_qty">
                                {{ pd_qty }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_code">Product Code</label>
                            <input type="text" :class="checkError('pd_code')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productInput.pd_code" placeholder="Product Code" />
                            <p class="text-danger" v-if="checkError('pd_code')" v-for="pd_code in errors.pd_code">
                                {{ pd_code }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_status">Status</label>
                            <select class="form-control" v-model="productInput.pd_status">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inctive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Unit Type </label>
                            <select class="form-control" v-model="productInput.unit_type">
                                <option disabled value="">Select Unit</option>
                                <option v-for="unit in units" :value="unit.id" :key="unit.id">
                                    {{ unit.unit_display }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_code">Colors
                                <toggle-button v-model="color_apply" :labels="{ checked: 'Yes', unchecked: 'No' }" /></label>
                            <v-multiselect-listbox v-if="color_apply" v-model="selectedColors" :options="allColors" :reduce-display-property="(option) => option.label" :reduce-value-property="(option) => option.code" no-options-text="No Colors" selected-no-options-text="No Colors Selected">
                            </v-multiselect-listbox>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="pd_code">Sizes
                                <toggle-button v-model="size_apply" :labels="{ checked: 'Yes', unchecked: 'No' }" />
                            </label>
                            <v-multiselect-listbox v-if="size_apply" v-model="selectedSizes" :options="allSizes" :reduce-display-property="(option) => option.label" :reduce-value-property="(option) => option.code" no-options-text="No Sizes" selected-no-options-text="No Sizes Selected">
                            </v-multiselect-listbox>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="video">Video Url </label>
                            <input type="text" class="form-control"  v-model="productInput.video" placeholder="Video Url"/>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input-tag placeholder="Meta Keywords" v-model="meta_keywords" class="form-control"></input-tag>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control" v-model="productInput.meta_description" placeholder="Meta Descriptions"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="pd_code">Badges/Statuses</label>
                            <v-multiselect-listbox  v-model="selectedProductTags" :options="allProductTags" :reduce-display-property="(option) => option.label" :reduce-value-property="(option) => option.code" no-options-text="No Tag" selected-no-options-text="No Tags Selected">
                            </v-multiselect-listbox>
                        </div>                        
                        <div class="allBadges">
                            <span>
                                <input type="checkbox" id="popular_stat" v-model="popular_stat" />
                                <label for="popular_stat">Popular</label>
                            </span>
                            <span>
                                <input type="checkbox" id="upsstat" v-model="upsstat" />
                                <label for="upsstat">Top Rated</label>
                            </span>
                            <span>
                                <input type="checkbox" id="new_stat" v-model="new_stat" />
                                <label for="new_stat">New Arrival</label>
                            </span>
                            <span>
                                <input type="checkbox" id="feature_stat" v-model="feature_stat" />
                                <label for="feature_stat">Feature</label>
                            </span>
                            <span>
                                <input type="checkbox" id="onsale_stat" v-model="onsale_stat" />
                                <label for="onsale_stat">On Sale</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="typo__label">Filter Options</label>
                        <multiselect 
                            v-model="value" 
                            :options="options" 
                            :multiple="true" 
                            group-values="libs" 
                            group-label="language"
                            :group-select="true" 
                            placeholder="Type to search" 
                            track-by="name" label="name">
                            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                        </multiselect> 
                        <!-- <pre class="language-json"><code>{{ value  }}</code></pre> -->                     
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="product_highlight">Product Highlight <span class="text-danger">*</span>
                                <toggle-button v-model="pd_heightlights_show" :labels="{ checked: 'Yes', unchecked: 'No' }" /></label>
                            <tinymce id="d1" :other_options="tinyOptions" v-if="pd_heightlights_show" v-model="productInput.product_highlight"></tinymce>
                            <p class="text-danger" v-if="checkError('product_highlight')" v-for="product_highlight in errors.product_highlight">
                                {{ product_highlight }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="product_detail">Product Detail
                                <toggle-button v-model="detail_status" :labels="{ checked: 'Yes', unchecked: 'No' }" :sync="true" />
                            </label>
                            <tinymce id="d2" :other_options="tinyOptions" v-if="detail_status" v-model="productInput.product_detail"></tinymce>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="product_specification">Product Specification
                                <toggle-button v-model="specification_status" :labels="{ checked: 'Yes', unchecked: 'No' }" :sync="true" /></label>
                            <tinymce id="d3" :other_options="tinyOptions" v-if="specification_status" v-model="productInput.product_specification"></tinymce>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="product_warranty">Product Warranty
                                <toggle-button v-model="warranties_status" :labels="{ checked: 'Yes', unchecked: 'No' }" :sync="true" /></label>
                            <tinymce id="d4" :other_options="tinyOptions" v-if="warranties_status" v-model="productInput.product_warranty"></tinymce>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Product Thumbnail ( Width: 480px, Height: 652px, Maximum Size: 300kb )  <span class="text-danger">*</span></label>
                            <UploadImages :max="1" @changed="handleThumbnail" />
                            <p class="text-danger" v-if="checkError('pd_thumbnail')" v-for="pd_thumbnail in errors.pd_thumbnail">
                                {{ pd_thumbnail }}
                            </p>
                            <img class="img-thumbnail edit_product_thumbnail" :src="product_image_url + productInput.pd_thumbnail" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Product Images ( Width: 480px, Height: 652px, Maximum Size: 300kb ) </label>
                            <UploadImages :max="10" @changed="handleProImages" />
                            <div class="productImagesList">
                                <div v-for="proImg in productInput.productimages">
                                    <img class="img-thumbnail edit_product_thumbnail" :src="product_image_url + proImg.pro_img_name" />
                                    <i @click="deleteProductImage(proImg.id, proImg.pro_img_name)" class="mdi mdi-delete-forever"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import Multiselect from 'vue-multiselect';
import InputTag from 'vue-input-tag';
import {
    VueEditor,
    Quill
} from "vue2-editor";
import UploadImages from "vue-upload-drop-images";
import vMultiselectListbox from 'vue-multiselect-listbox';
import 'vue-multiselect-listbox/dist/vue-multi-select-listbox.css';
export default {
    components: {
        CardHeader,
        UploadImages,
        VueEditor,
        Quill,
        vMultiselectListbox,
        'input-tag': InputTag,
        Multiselect
    },
    data() {
        return {
            meta_keywords: [],
            product_image_url: null,
            productInput: {},
            categories: [],
            brands: [],
            units: [],
            errors: [],
            allColors: [],
            selectedColors: [],
            allSizes: [],
            selectedSizes: [],
            allProductTags:[],
            selectedProductTags:[],
            loading: false,            
            pd_heightlights_show: true,
            detail_status: true,            
            specification_status: true,            
            warranties_status: true,
            popular_stat: false,
            upsstat: false,
            new_stat: false,
            feature_stat: false,
            onsale_stat: false,
            color_apply: true,
            size_apply: true,
            inputThumbnail: null,
            product_images: [],
            tinyOptions: {'height': 200},
            options: [ ],
            value: [ ],
            selectedvalue:[]
        };
    },
    created() {
        this.getProduct();
      
    },
    watch: {
        
        value (newValues) {
             //this.form.books = newValues.map(obj => obj.id);
        }
    },
    methods: {
        checkError(field) {
            if (!this.isEmpty(this.errors)) {
                if (field in this.errors) {
                    return true
                }
            }
            return false;
        },
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        async getProduct() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages(
                `/api/user/products/${this.$route.params.id}`
            );
            this.product_image_url = data[0].url;
            this.productInput = data[0].data[0];
            this.popular_stat = this.productInput.popular_stat ? true : false;
            this.upsstat = this.productInput.upsstat ? true : false;
            this.new_stat = this.productInput.new_stat ? true : false;
            this.feature_stat = this.productInput.feature_stat ? true : false;
            this.onsale_stat = this.productInput.onsale_stat ? true : false;
            this.detail_status = this.productInput.detail_status ? true : false;
            this.specification_status = this.productInput.specification_status ? true : false;
            this.warranties_status = this.productInput.warranties_status ? true : false;
            if (this.productInput.product_filter_tag) {
                this.selectedvalue = this.productInput.product_filter_tag.split(',');
            }
            if (this.productInput.meta_keyword) {
                this.meta_keywords = this.productInput.meta_keyword.split(',')
            }

            Promise.all([
                this.getAllCategories(),
                this.getAllBrands(),
                this.getAllUnits(),
                this.getAllColors(),
                this.getAllSizes(),
                this.getAllProductTags(),
                this.getAllfilters(),
                this.getAllfilters_selected(),

            ]).then((res) => {
                this.categories = res[0];
                this.brands = res[1];
                this.units = res[2];
                this.allColors = res[3];
                this.allSizes = res[4];
                this.allProductTags = res[5];
                this.productInput.productcolors.forEach((color) => {
                    this.selectedColors.push(color.color_id);
                });
                this.productInput.productsizes.forEach((size) => {
                    this.selectedSizes.push(size.size_id);
                });

                 this.productInput.productactivetags.forEach((tag) => {
                     this.selectedProductTags.push(tag.tagid);
                 });

                this.loading = false;
            });
        },
        async getAllCategories() {
            return await this.$root.getAllData("/api/user/categories");
        },
        async getAllBrands() {
            return await this.$root.getAllData("/api/user/brands");
        },
        async getAllColors() {
            let data = await this.$root.getAllData("/api/user/colors");
            let dataArr = data.map(item => {
                return {
                    label: item.color_name,
                    code: item.id
                }
            });
            return dataArr;
        },
        async getAllUnits() {
            return await this.$root.getAllData("/api/user/units");
        },

        async getAllSizes() {
            let data = await this.$root.getAllData("/api/user/sizes");
            let dataArr = data.map(item => {
                return {
                    label: item.size_display,
                    code: item.id
                }
            });
            return dataArr;
        },

        async getAllProductTags() {
            let data = await this.$root.getAllData("/api/user/producttags");
            let dataArr = data.map(item => {
                return {
                    label: item.tag_label,
                    code: item.id
                }
            })
            return dataArr;
        },
        async getAllfilters() {
            let dataObj = {
                'status':1
            };
            let data = await this.$root.addData(dataObj,"/api/user/productFilter/param");
            let fdata= data.data.data;
            let optionsArr = [];
            fdata.forEach(el => {
                let tempObj = {};
                tempObj['language'] = el['name'];
                let libs = [];
                el.filteroptions.forEach(filter => {
                    libs.push({name: filter.option_name+'->'+ el['name'], category: filter.id});
                })
                tempObj['libs'] = libs;
                optionsArr.push(tempObj);
            })
            //console.dir(optionsArr)
            this.options=optionsArr;
        },

        async getAllfilters_selected() {
            if(this.selectedvalue && this.selectedvalue.length){
            let dataObj = {
                'selectedvalue':this.selectedvalue
            };
            let data = await this.$root.addData(dataObj,"/api/user/productFilter/param_selected");
            let fdata= data.data.data;
            let libs = [];
             fdata.forEach(el => {                
               // console.log(el.productfilter.name); 
                libs.push({name: el.option_name+'->'+el.productfilter.name, category: el.id});               
            })
            //console.dir(libs)
            this.value=libs;
            }
        },

        handleThumbnail(files) {
            this.inputThumbnail = files[0];
        },
        handleProImages(files) {
            this.product_images = files;
        },
        deleteProductImage(id, imgName) {
            this.$confirm("Are you sure to delete?").then(() => {
                var config = {
                    method: "post",
                    url: `${this.$store.state.hostBase}/api/user/products/delete_image/${id}/${imgName}`,
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                    },
                };
                this.axios(config)
                    .then((response) => {
                        this.$fire({
                            title: "Image Deleted Successfully",
                            type: "success",
                            timer: 2000
                        });
                        this.productInput.productimages = this.productInput.productimages.filter(pImg => {
                            if (pImg.id !== id) {
                                return pImg;
                            }
                        })
                    })
                    .catch((error) => {
                        this.$fire({
                            title: "Failed to delete",
                            type: "warning",
                            timer: 2000
                        })
                    });
            });
        },
        updateProduct(event) {
            let filter_data=[];
            this.value.forEach(element =>filter_data.push(element.category));
            var form = new FormData();

            this.productInput.meta_keyword = this.meta_keywords.join(',');
            form.append("meta_keyword", this.productInput.meta_keyword);
            form.append("product_filter_tag", filter_data.join(','));
            form.append("pd_name", this.productInput.pd_name);
            form.append("category_id", this.productInput.category_id);
            form.append("brand_id", this.productInput.brand_id);
            form.append("unit_type", this.productInput.unit_type);
            form.append("pd_price", this.productInput.pd_price);
            form.append("pd_code", this.productInput.pd_code);
            form.append("prod_type", "1");
            form.append("pd_prev_price", this.productInput.pd_prev_price);
            form.append("pd_qty", this.productInput.pd_qty);
            form.append("video", this.productInput.video);
            form.append("meta_description", this.productInput.meta_description);
            this.popular_stat ? form.append("popular_stat", 1) : form.append("popular_stat", 0);
            this.upsstat ? form.append("upsstat", 1) : form.append("upsstat", 0);
            this.new_stat ? form.append("new_stat", 1) : form.append("new_stat", 0);
            form.append("product_detail", this.productInput.product_detail);
            form.append("product_specification", this.productInput.product_specification);
            form.append("product_warranty", this.productInput.product_warranty);
            form.append("pd_status", this.productInput.pd_status);
            this.feature_stat ? form.append("feature_stat", 1) : form.append("feature_stat", 0);
            this.onsale_stat ? form.append("onsale_stat", 1) : form.append("onsale_stat", 0);
            this.color_apply ? form.append("color_apply", 1) : form.append("color_apply", 0);
            this.size_apply ? form.append("size_apply", 1) : form.append("size_apply", 0);

            this.detail_status ? form.append("detail_status", 1) : form.append("detail_status", 0);

            this.specification_status ? form.append("specification_status", 1) : form.append("specification_status", 0);
          
            this.warranties_status ? form.append("warranties_status", 1) : form.append("warranties_status", 0);
            
            form.append("product_highlight", this.productInput.product_highlight);
            this.selectedColors.forEach((color) => {
                form.append("colors[]", color);
            });
            this.selectedSizes.forEach((size) => {
                form.append("sizes[]", size);
            });
            this.selectedProductTags.forEach((producttag) => {
                form.append("producttags[]", producttag);
            });
            this.product_images.forEach((image) => {
                form.append("pro_img_name[]", image);
            });
            form.append("pd_thumbnail", this.inputThumbnail);
            form.append("hst", this.productInput.hst ? this.productInput.hst : 0);
            //console.log(this.productInput);
            this.axios
                .post(`${this.$store.state.hostBase}/api/user/products/${this.$route.params.id}?_method=PUT`, form, {
                    headers: {
                        Authorization: `Bearer ${this.$store.state.token}`,
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    this.$fire({
                        title: res.data.message,
                        type: "success",
                        timer: 2000
                    });
                    this.$router.push({
                        name: "products",
                    });
                    event.target.reset();
                })
                .catch((err) => {
                    console.dir(err);
                    let res = JSON.parse(err.request.response);
                    if (res.status == "error") {
                        this.errors = JSON.parse(err.request.response).validation_errors;
                    } else {
                        this.$fire({
                            title: "Failed to update",
                            type: "warning",
                            timer: 2000
                        });
                    }
                });
        },
    },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
img.edit_product_thumbnail {
    height: 100px;
}

.productImagesList {
    display: flex;
    flex-wrap: wrap;
}

.productImagesList div {
    position: relative;
    flex-wrap: wrap;
}

.productImagesList div i {
    position: absolute;
    font-size: 20px;
    right: 0;
    top: 0px;
    color: #dc3939;
    cursor: pointer;
    background: #fff;
    border-radius: 3px;
}
</style>
