<template>
  <!-- category -->
  <div class="container">
    <section class="section-b-space border-section border-top-0">
      <div class="row">
        <div class="col">
          <div class="slide-6 no-arrow">
            <div v-swiper:mySwiper="swiperOption">
              <div class="swiper-wrapper">
                <!-- <div class="swiper-slide" v-for="(item, index) in items" :key="index">
                  <div class="category-block">
                    <a href="#">
                      <div class="category-image">
                        <img :src="item.img" alt>
                      </div>
                    </a>
                    <div class="category-details">
                      <a href="#">
                        <h5>{{item.title}}</h5>
                      </a>
                    </div>
                  </div>
                </div> -->
				<div class="swiper-slide">
				  <div class="category-block">
				    <a href="#">
				      <div class="category-image">
				        <img src="frontimages/icon/cat1.png" alt>
				      </div>
				    </a>
				    <div class="category-details">
				      <a href="#">
				        <h5>{{item.title}}</h5>
				      </a>
				    </div>
				  </div>
				</div>
				<div class="swiper-slide">
				  <div class="category-block">
				    <a href="#">
				      <div class="category-image">
				        <img src="frontimages/icon/cat2.png" alt>
				      </div>
				    </a>
				    <div class="category-details">
				      <a href="#">
				        <h5>{{item.title}}</h5>
				      </a>
				    </div>
				  </div>
				</div>
				<div class="swiper-slide">
				  <div class="category-block">
				    <a href="#">
				      <div class="category-image">
				        <img src="frontimages/icon/cat3.png" alt>
				      </div>
				    </a>
				    <div class="category-details">
				      <a href="#">
				        <h5>{{item.title}}</h5>
				      </a>
				    </div>
				  </div>
				</div>
				<div class="swiper-slide">
				  <div class="category-block">
				    <a href="#">
				      <div class="category-image">
				        <img src="frontimages/icon/cat4.png" alt>
				      </div>
				    </a>
				    <div class="category-details">
				      <a href="#">
				        <h5>{{item.title}}</h5>
				      </a>
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
  <!-- category end -->
</template>

<script>
export default {
  data() {
    return {
      swiperOption: {
        dots: false,
        loop: true,
        slideSpeed: 300,
        slidesPerView: 7,
        breakpoints: {
          1367: {
            slidesPerView: 5,
            loop: true
          },
          1024: {
            slidesPerView: 4,
            loop: true
          },
          767: {
            slidesPerView: 3,
            loop: true
          },
          480: {
            slidesPerView: 2
          },
          0: {
            slidesPerView: 2
          },
        }
      }
    }
  }
}
</script>
