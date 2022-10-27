<template>
  <div>
    <section class="p-0">
      <div
        class="full-banner parallax text-center p-left"
        v-bind:style="{ backgroundImage: 'url(' + bannerImageUrl + banner.image + ')' }"
      >
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="banner-contain">
                <h2>{{ banner.main_text }}</h2>
                <h3>{{ banner.second_text }}</h3>
                <h4>{{ banner.additional_text }}</h4>
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
      bannerImageUrl: "",
      banner: {},
    }
  },
  created() {
    this.getBanner();
  },
  methods: {
    async getBanner() {
      let dataObj = {
        'active_status': '1',
        // 'bg_type': '2'
      };
      let slideData = await this.$root.getFrontData(dataObj, '/api/sliderbackground_param');
      this.bannerImageUrl = slideData.data.url;
      this.banner = slideData.data.data[0];
    },
  }
}
</script>
