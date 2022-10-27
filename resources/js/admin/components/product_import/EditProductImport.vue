<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Edit Product Import" btnRoute="product_imports" btnName="Products Import" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <form @submit.prevent="updateProduct($event)" v-bind:class="{ lessOpacity: loading }">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="product_name">Product Name <span class="text-danger">*</span></label>
                            <input type="text" v-model="productImport.product_name" placeholder="Product Name" :class="checkError('product_name')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " />
                            <p class="text-danger" v-if="checkError('product_name')" v-for="product_name in errors.product_name">
                                {{ product_name }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Category <span class="text-danger">*</span></label>
                            <select :class="
                                checkError('category')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="productImport.category">
                                <option disabled value="">Select Category</option>
                                <option v-for="category in categories" :value="category.cat_name" :key="category.cat_name">
                                    {{ category.cat_name }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('category')" v-for="category in errors.category">
                                {{ category }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="country">Brand <span class="text-danger">*</span></label>
                            <select :class="
                                checkError('brand')
                                ? 'form-control border-danger'
                                : 'form-control'
                            " v-model="productImport.brand">
                                <option disabled value="">Select Brand</option>
                                <option v-for="brand in brands" :value="brand.brand_display" :key="brand.brand_display">
                                    {{ brand.brand_display }}
                                </option>
                            </select>
                            <p class="text-danger" v-if="checkError('brand')" v-for="brand in errors.brand">
                                {{ brand }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="price">Price <span class="text-danger">*</span></label>
                            <input type="number" :class="checkError('price')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productImport.price" placeholder=" Price" min="1" />
                            <p class="text-danger" v-if="checkError('price')" v-for="price in errors.price">
                                {{ price }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="qty">Qty <span class="text-danger">*</span></label>
                            <input type="number" :class="checkError('qty')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productImport.qty" placeholder="Qty"   />
                            <p class="text-danger" v-if="checkError('qty')" v-for="qty in errors.qty">
                                {{ qty }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="img">Image Name<span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('img')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productImport.img" placeholder="Image Name"   />
                            <p class="text-danger" v-if="checkError('img')" v-for="img in errors.img">
                                {{ img }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="highlight">Description <span class="text-danger">*</span></label>
                            <input type="text" :class="checkError('highlight')
                                ? 'form-control border-danger'
                                : 'form-control' " v-model="productImport.highlight" placeholder="Description"  />
                            <p class="text-danger" v-if="checkError('highlight')" v-for="highlight in errors.highlight">
                                {{ highlight }}
                            </p>
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
export default {
    components: {
        CardHeader,
    },
    data() {
        return {
            errors: [],
            loading: false,
            productImport: {},
            categories: [],
            brands: [],
        }
    },
    created() {
        this.getProductImport();
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

        async getProductImport() {

            this.loading = true;
            
            let data = await this.$root.getAllDataWithImages(
                `/api/user/productimport/${this.$route.params.id}`
            );
            this.productImport = data[0].data[0];


            Promise.all([
                this.getAllCategories(),
                this.getAllBrands(),                
            ]).then((res) => {
                this.categories = res[0];
                this.brands = res[1];
            });


            this.loading = false;
        },
        async getAllCategories() {
            return await this.$root.getAllData("/api/user/categories");
        },
        async getAllBrands() {
            return await this.$root.getAllData("/api/user/brands");
        },
        updateProduct(event) {

            this.$root.updateData(this.productImport, `/api/user/productimport/${this.$route.params.id}`).then(response => {
                this.$fire({
                    title: response.data.message,
                    type: "success",
                    timer: 2000
                });
                this.$router.push({
                    name: "product_imports",
                });
                event.target.reset();
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res)
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    this.$fire({
                        title: "Failed to update",
                        type: "warning",
                        timer: 2000
                    });
                }
            })
        }
    }
}
</script>

