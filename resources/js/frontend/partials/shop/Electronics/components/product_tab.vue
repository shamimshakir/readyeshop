<template>
  <div>
    <section class="section-b-space ratio_square">
      <div class="container-fluid">
        <div class="title2">
          <h4>{{subtitle}}</h4>
          <h2 class="title-inner2">{{title}}</h2>
        </div>
        <div class="row">
          <div class="col">
            <div class="theme-tab layout7-product">
              <b-tabs content-class="mt-3">
                <b-tab :title="tabItem.title" v-for="(tabItem, index) in tabProducts" :key="index">
									<div class="no-slider row">
										<div class="product-box" v-for="(tabPro, index) in tabItem.products" :key="index">
											<productBox1
												@openquickview="showquickview"
												:product="tabPro"
												:index="index"
												:image-src="imageSrc"
											/>
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
</template>
<script type="text/javascript">
import productBox1 from '../../../../components/product-box/product-box1'
export default {
	props: ['category'],
	components: {
		productBox1
	},
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
	methods: {
		async getTabCategoryProducts(value) {
			for (let cats of this.category) {
				let dataObj = {
					[cats.value]: 1,
					// 'category[]': 71
				}
				let productsData = await this.$root.getFrontData(dataObj, `/api/product_param?page=1&limit=12`);
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
