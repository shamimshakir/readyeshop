<template>
  <div>
    <div class="bg-block">
      <section class="p-0">
        <div class="container-fluid">
          <div class="row">
            <div class="col">
              <div class="title4">
                <h2 class="title-inner4">{{title}}</h2>
                <div class="line">
                  <span></span>
                </div>
              </div>
              <div class="theme-tab">
                <b-tabs content-class="mt-3">
                  <b-tab :title="product.title" v-for="(product,index) in tabProducts" :key="index">
                    <div class="row product-tab">
                      <div
                        class="tab-box"
                        v-for="(tabPro,index) in product.products"
											  :key="index"
                      >
                        <div class="product-box2">
                          <div class="media">
                            <router-link :to="{
                                  name: 'productdetails',
                                  params: {
                                  pdname: tabPro.pd_name.replace(/\s+/g, '-').toLowerCase(),
                                  id: tabPro.id,
                                  },
                              }">
                            <img :src="imageSrc+tabPro.pd_thumbnail" :id="tabPro.id" class="img-fluid bg-img" :alt="tabPro.title"
                              :key="index" />
                          </router-link>
                            <div class="media-body align-self-center">
                              <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                              </div>
                              <router-link :to="{
                                  name: 'productdetails',
                                  params: {
                                    pdname: tabPro.pd_name.replace(/\s+/g, '-').toLowerCase(),
                                    id: tabPro.id,
                                  },
                                }">
                                <h6>{{ tabPro.pd_name }}</h6>
                              </router-link>
                              <p>{{ tabPro.product_detail }}</p>
                              <h4 v-if="tabPro.onsale_stat">
                                {{currency + tabPro.pd_price }}
                                <del>{{ currency +tabPro.pd_prev_price }}</del>
                              </h4>
                              <h4 v-else>{{currency + tabPro.pd_price }}</h4>
                              <ul class="color-variant" v-if="tabPro.productcolors.length > 0">
                                <li v-for="(variant, variantIndex) in tabPro.productcolors" :key="variantIndex">
                                  <a :class="[variant.color.color_name]"
                                    v-bind:style="{ 'background-color': variant.color.color_name }"></a>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </b-tab>
                </b-tabs>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>
<script type="text/javascript">
  export default {
		props: ['category'],
		data() {
			return {
				title: 'special products',
				subtitle: 'exclusive products',
				showCart: false,
				showquickviewmodel: false,
				quickviewproduct: {},
				tabProducts: [],
				imageSrc: ""
			}
		},
		created() {
			this.getTabCategoryProducts();
		},
    computed: {
			currency() {
				return this.$store.state.siteCurrency;
			},
		},
		methods: {
			async getTabCategoryProducts(value) {
				for (let cats of this.category) {
					let dataObj = {
						[cats.value]: 1
					}
					let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=16`);
					let productsArr = productsData.data.data.data;
					this.imageSrc = productsData.data.url;
					this.tabProducts.push({
						title: cats.name,
						label: cats.value,
						products: productsArr
					});
				}
			},
			showquickview(item, productData) {
				this.showquickviewmodel = item
				this.quickviewproduct = productData
				this.$emit('openQuickview', this.showquickviewmodel, this.quickviewproduct)
			},
		}
	}
</script>
