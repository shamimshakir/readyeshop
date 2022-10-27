<template>
  <div>
    <section class="banner-goggles ratio2_3">
      <div class="container-fluid">
        <div class="row partition3">
          <div class="col-md-4" v-for="(item, index) in promotion" :key="index">
            <router-link :to="{ path: '/collection/leftsidebar/all' }">
              <div class="collection-banner p-left text-center">
                <div class="img-part">
                  <img :src="imageSrc + item.image" class="img-fluid" alt />
                </div>
                <div class="contain-banner banner-3">
                  <div>
                    <h4>{{ item.promotionpercent }}</h4>
                    <h2>{{ item.name }}</h2>
                  </div>
                </div>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script type="text/javascript">
export default {
  data() {
    return {
      promotion: [],
      imageSrc: "",
    }
  },
  created() {
    this.getAllPromotion();
  },
  methods: {
    async getAllPromotion() {
      let dataObj = {
        status: 1
      };
      let promotionData = await this.$root.getFrontData(dataObj, `/api/promotions_param`);
      //console.log(wishlistData);

      this.promotion = promotionData.data.data;
      this.imageSrc = promotionData.data.url;

    }
  }
}
</script>
