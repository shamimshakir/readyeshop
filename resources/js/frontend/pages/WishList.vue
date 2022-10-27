<template>
  <div>
    <Header />
    <Breadcrumbs title="wishlist" />
    <section class="wishlist-section section-b-space">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <table class="table cart-table table-responsive-xs" v-if="wishlist.length">
              <thead>
                <tr class="table-head">
                  <th scope="col">image</th>
                  <th scope="col">product name</th>
                  <th scope="col">price</th>
                  <th scope="col">availability</th>
                  <th scope="col">action</th>
                </tr>
              </thead>
              <tbody v-for="(item,index) in wishlist" :key="index">
                <tr>
                  <td>
                    <a href="#">
                      <img :src='imageSrc +item.products.pd_thumbnail' alt="">
                    </a>
                  </td>
                  <td>
                    <a href="#">{{item.products.pd_name}}</a>
                    <div class="mobile-cart-content row">
                      <div class="col-xs-3">
                        <p>in stock</p>
                      </div>
                      <div class="col-xs-3">
                        <h2 class="td-color">{{ currency+item.products.pd_price }}</h2>
                      </div>
                      <div class="col-xs-3">
                        <h2 class="td-color">
                          <a href="#" class="icon mr-1">
                            <i class="ti-close" @click="deleteToWishList(item.id)"></i>
                          </a>
                          <a href="#" class="cart">
                            <i class="ti-shopping-cart" @click="addToCart(item.products.id)"></i>
                          </a>
                        </h2>
                      </div>
                    </div>
                  </td>
                  <td>
                    <h2>{{ currency+item.products.pd_price }}</h2>
                  </td>
                  <td>
                    <p>in stock</p>
                  </td>
                  <td>
                    <a href="javascript:void(0)" class="icon mr-3" @click="deleteToWishList(item.id)">
                      <i class="ti-close"></i>
                    </a>
                    <a href="javascript:void(0)" class="cart" @click="addToCart(item.products.id)">
                      <i class="ti-shopping-cart" ></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="row wishlist-buttons" v-if="wishlist.length">
          <div class="col-12">
            <router-link :to="{ path: '/'}" :class="'btn btn-solid'">continue shopping</router-link>
          </div>
        </div>
        <div class="col-sm-12 empty-cart-cls text-center" v-if="!wishlist.length">
              <img :src='"/frontimages/empty-wishlist.png"' class="img-fluid" alt="empty cart" />
              <h3 class="mt-3">
                <strong>Your Wishlist is Empty</strong>
              </h3>
              <div class="col-12">
                <router-link :to="{ path: '/'}" class="btn btn-solid">continue shopping</router-link>
              </div>
            </div>
      </div>
    </section>
    <Footer />
  </div>
</template>
<script>
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
import Breadcrumbs from '../components/widgets/breadcrumbs'
export default {
  components: {   
    Header,
		Footer,
    Breadcrumbs
  },

  computed: {
   currency() {
            return this.$store.state.siteCurrency;
        },

  },
  data() {
    return {
       wishlist: [],
       imageSrc: "",
       meta: {},
    }
  },
  created() {
        this.getAllWishListDetail();
        this.getMeta();
    },
  methods: {
    async getAllWishListDetail() {
            let sessionData = JSON.parse(sessionStorage.getItem("session_id"));
            let dataObj = {
              'session_id': sessionData.id
            };
            let wishlistData = await this.$root.getFrontData(dataObj, `/api/wishlist/show`);
            //console.log(wishlistData);

            this.wishlist = wishlistData.data.data;
            this.imageSrc = wishlistData.data.url;
            
    },
    async getMeta() {
            let dataObj = {
                'meta_page': 'wishlist',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
    },
    addToCart(proId) {
      this.$store.dispatch("addToCart", proId);
    },
    async deleteToWishList(id){
        let session_id = JSON.parse(sessionStorage.getItem("session_id"));
        let sessionId = session_id.id;
        let dataObj = {
            'id': id,
            'session_id': sessionId,
        }            
        try {
            await this.$root.getFrontData(dataObj, `/api/wishlist/delete`);
            this.getAllWishListDetail();
        } catch (err) {
            console.log(err)
        }

    }
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
