<template>
  <div>
    <section class="banner-padding banner-furniture gym-banner">
      <div class="container-fluid">
        <div class="row partition2">
          <div class="col-md-4">
            <a href="#">
              <div class="collection-banner p-left text-left">
                <div class="img-part">
                  <img v-if="firstCol.image" :src="imageSrc +firstCol.image" class="img-fluid" alt />
                </div>
                <div class="contain-banner">
                  <div>
                    <h4>{{firstCol.promotionpercent}}</h4>
										<h2>{{firstCol.name}}</h2>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-8">
            <a href="#">
              <div class="collection-banner p-left text-left">
                <div class="img-part">
                  <img v-if="secondCol.image" :src="imageSrc +secondCol.image" class="img-fluid" alt />
                </div>
                <div class="contain-banner">
                  <div>
                    <h4>{{secondCol.promotionpercent}}</h4>
										<h2>{{secondCol.name}}</h2>
                  </div>
                </div>
              </div>
            </a>
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
        firstCol: {},
        secondCol: {},
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
				this.promotion = promotionData.data.data;
        this.firstCol = this.promotion[0];
        this.secondCol = this.promotion[1];
				this.imageSrc = promotionData.data.url;

			}
		}
	}
</script>
