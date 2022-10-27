<template>
  <div>
    <Header />
    <Breadcrumbs title="Comapre" />
    <section class="compare-padding">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="compare-page" v-if="compare.length">
              <div class="table-wrapper table-responsive">
                <table class="table">
                  <thead>
                    <tr class="th-compare">
                      <td>Action</td>
                      <th class="item-row" v-for="(item,index) in compare" :key="index">
                        <button type="button" class="remove-compare" @click="deleteToCompare(item.id)">Remove</button>
                      </th>
                    </tr>
                  </thead>
                  <tbody id="table-compare">
                    <tr>
                      <th class="product-name">Product Name</th>
                      <td class="grid-link__title" v-for="(item,index) in compare" :key="index">{{item.products.pd_name}}</td>
                    </tr>
                    <tr>
                      <th class="product-name">Product Image</th>
                      <td class="item-row" v-for="(item,index) in compare" :key="index">
                        <img :src='imageSrc +item.products.pd_thumbnail' alt="" class="featured-image">
                        <div class="product-price product_price">
                          <strong v-if="item.sale">On Sale:</strong>
                          <span>{{ currency+item.products.pd_price }}</span>
                        </div>                        
                          <button title="Add to Cart" class="add-to-cart btn btn-solid" @click="addToCart(item.products.id)">Add to Cart</button>                        
                        <h4 class="grid-link__title hidden pt-2">{{item.products.pd_name}}</h4>
                      </td>
                    </tr>
                    <tr>
                      <th class="product-name">Product Description</th>
                      <td class="item-row" v-for="(item,index) in compare" :key="index">
                        <p class="description-compare" v-html="item.products.product_highlight"
                        ></p>
                      </td>
                    </tr>
                    <tr>
                      <th class="product-name">Availability</th>
                      <td class="available-stock" v-for="(item,index) in compare" :key="index">
                        <p>Available In stock</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="empty-cart-cls text-center" v-if="!compare.length">
              <img :src='"/frontimages/empty-compare.png"' class="img-fluid" alt="empty cart" />
              <h3 class="mt-3">
                <strong>Your Compare List is Empty</strong>
              </h3>
              <div class="col-12">
                <router-link :to="{ path: '/'}" class="btn btn-solid">continue shopping</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <Footer />
  </div>
</template>

<script>

import Breadcrumbs from '../components/widgets/breadcrumbs'
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
export default {
  components: {   
    Breadcrumbs,
    Header,
		Footer,
  },
  computed: {
   currency() {
            return this.$store.state.siteCurrency;
        },
  },
  data() {
    return {
       compare: [],
       imageSrc: "",
       meta: {},
    }
  },
  created() {
        this.getAllCompare();
        this.getMeta();
    },
  methods: {
    async getAllCompare() {
            let sessionData = JSON.parse(sessionStorage.getItem("session_id"));
            let dataObj = {
              'session_id': sessionData.id
            };
            let compareData = await this.$root.getFrontData(dataObj, `/api/compare/show`);
            //console.log(wishlistData);

            this.compare = compareData.data.data;
            this.imageSrc = compareData.data.url;
            
        },
        addToCart(proId) {
          this.$store.dispatch("addToCart", proId);
        },
    async deleteToCompare(id){
        let session_id = JSON.parse(sessionStorage.getItem("session_id"));
        let sessionId = session_id.id;
        let dataObj = {
            'id': id,
            'session_id': sessionId,
        }            
        try {
            await this.$root.getFrontData(dataObj, `/api/compare/delete`);
            this.getAllCompare();
        } catch (err) {
            console.log(err)
        }

    },
    async getMeta() {
            let dataObj = {
                'meta_page': 'compare',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
    },
  },
  metaInfo() {
        return {            
            title:  this.meta.meta_name, 
            meta: [
                { name: 'description', content:  this.meta.meta_content},
                { name: 'keywords', content:  this.meta.meta_type},
                { property: 'og:title', content: this.meta.meta_content},
                { property: 'og:site_name', content: this.meta.meta_name},
                {property: 'og:type', content: 'website'},    
                {name: 'robots', content: 'index,follow'} 
            ]
        }
  },
}
</script>
