<template>
  <div>
  <section class="p-0" v-if="!orderId">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="error-section">
              <h1>404</h1>
              <h2>page not found</h2>
              <router-link :to="{ path: '/'}" :class="'btn btn-solid'"> back to home</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- thank-you section start -->
    <section class="section-b-space light-layout" v-if="orderId">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="success-text">
              <i class="fa fa-check-circle" aria-hidden="true"></i>
              <h2>thank you</h2>
              <p>Payment is successfully processsed and your order is on the way</p>
              <p>Transaction ID:{{order.od_no}}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section ends -->
    <!-- order-detail section start -->
    <section class="section-b-space" v-if="orderId">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="product-order">
              <h3>your order details</h3>
              <div class="row product-order-detail" v-for="(item,index) in order.orderitems" :key="index">
                <div class="col-3">
                  <img :src="imageSrc + item.product.pd_thumbnail" alt class="img-fluid" />
                </div>
                <div class="col-3 order_detail">
                  <div>
                    <h4>product name</h4>
                    <h5>{{item.product.pd_name}}</h5>
                  </div>
                </div>
                <div class="col-3 order_detail">
                  <div>
                    <h4>quantity</h4>
                    <h5>{{item.od_qty}}</h5>
                  </div>
                </div>
                <div class="col-3 order_detail">
                  <div>
                    <h4>price</h4>
                    <h5>{{ currency }}</h5>
                  </div>
                </div>
              </div>
              <div class="total-sec">
                <ul>
                  <li>
                    Total
                    <span>{{ currency }}{{ order.total_cost }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row order-success-sec">
              <div class="col-sm-6">
                <h4>summery</h4>
                <ul class="order-detail">
                  <li>order ID: {{order.od_no}}</li>
                  <li>Order Date: October 18, 2020</li>
                  <li>Order Total: {{ currency }}{{ order.total_cost }}</li>
                </ul>
              </div>
              <div class="col-sm-6">
                <h4>shipping address</h4>
                <ul class="order-detail">
                  <li>{{ order.od_shipping_address1 }}</li>
                  <li>{{ order.od_shipping_postal_code }}{{ order.od_shipping_thana }}</li>
                  <li>Austrlia, 235153</li>
                  <li>Contact No. 987456321</li>
                </ul>
              </div>
              <div class="col-sm-12 payment-mode">
                <h4>payment method</h4>
                <p>Pay on Delivery (Cash/Card). Cash on delivery (COD) available. Card/Net banking acceptance subject to device availability.</p>
              </div>
              <!-- <div class="col-md-12">
                <div class="delivery-sec">
                  <h3>expected date of delivery</h3>
                  <h2>october 22, 2020</h2>
                </div>
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Section ends -->
  </div>
</template>
<script>
export default {
  data(){
    return {
      order: {},
      imageSrc: "",
    }
  },
  computed: {
    orderId() {
      return this.$route.params.order_id;
    },
    currency() {
      return this.$store.state.siteCurrency;
    },
  },
  created(){
    this.getOrderDetails();
  },
  methods: {
    async getOrderDetails() {
        let dataObj = {
          id: this.$route.params.order_id
        };
        let data = await this.$root.getDetailsData(dataObj,`/api/customer/order/view`);
        this.imageSrc = data.data.url;
        this.order = data.data.data[0];
    }, 
  }
}
</script>
