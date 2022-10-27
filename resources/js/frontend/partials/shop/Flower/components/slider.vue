<template>
  <div>
    <section class="p-0">
      <div class="slide-1 home-slider">
        <div v-swiper:mySwiper="swiperOption">
          <div class="swiper-wrapper">
            <div class="swiper-slide" v-for="slider in sliders">
              <div
                class="home text-center"
                :style="{ backgroundImage: `url(${sliderImageUrl}${slider.bg_img})` }"
              >
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <div class="slider-contain">
                        <div>
                          <h4>{{ slider.title_text }}</h4>
                          <h1>{{ slider.main_text }}</h1>
                          <router-link :to="{ path: '/shop' }" class="btn btn-solid" exact>shop now</router-link>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-button-prev" slot="button-prev"></div>
          <div class="swiper-button-next" slot="button-next"></div>
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
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            },
            sliderImageUrl: "",
            sliders: [

            ],
        }
    },
    created() {
        this.getSliders();
    },
    methods: {
        async getSliders() {
            let dataObj = {
                'slider_id': '2',
                'act_status': '1',
                'slider_id': 1
            };
            let slideData = await this.$root.getFrontData(dataObj, '/api/slider_param');
            this.sliderImageUrl = slideData.data.url;
            this.sliders = slideData.data.data;
            // console.log(this.sliders)
        },
    }
}
</script>
