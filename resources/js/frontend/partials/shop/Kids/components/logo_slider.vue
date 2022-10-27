<template>
  <div v-if="checkAvailability">
    <section class="section-b-space">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="slide-6 no-arrow">
              <div v-swiper:mySwiper="swiperOption">
                <div class="swiper-wrapper">
                  <div class="swiper-slide" v-for="(item, index) in items" :key="index">
                    <div>
                      <div class="logo-block text-center">
                         <a :href="item.link">
                          <img
                            style="width: 100%; max-height: 230px;"
                            :src="imageSrc + item.logo"
                            class="img-fluid"
                            :alt="item.name"
                          />
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
      swiperOption: {
        slidesPerView: 6,
        freeMode: true,
        checkAvailability: 0,
        breakpoints: {
          1199: {
            slidesPerView: 6
          },
          768: {
            slidesPerView: 4
          },
          420: {
            slidesPerView: 3
          },
          0: {
            slidesPerView: 2,
          }
        }
      },
      items: [],
      imageSrc: "",
    }
  },
  created() {
    this.getLogos();
  },
  methods: {
    async getLogos() {
      let dataObj = {
        'act_status': '1'
      };
      let logData = await this.$root.getFrontData(dataObj, '/api/sponsor_param');
      this.items = logData.data.data;
      this.checkAvailability = logData.data.count;
      this.imageSrc = logData.data.url;
    },
  }
}
</script>
