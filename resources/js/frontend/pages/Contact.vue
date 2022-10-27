<template>
    <div>
    <Header />
    <Breadcrumbs title="Contact" />
    <section class="contact-page section-b-space">
      <vue-loaders-ball-clip-rotate-multiple v-if="pageLoading" scale="1.5" color="#000" />
      <div class="container"  v-bind:class="{ lessOpacity: pageLoading }">
        <div class="row section-b-space">
          <div class="col-lg-7 map" v-html="getDetail.contact_map_location">
                        
            <!--<iframe
              src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1605.811957341231!2d25.45976406005396!3d36.3940974010114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1550912388321"
              allowfullscreen
            ></iframe>-->
          </div>
          <div class="col-lg-5">
            <div class="contact-right">
              <ul>
                <li>
                  <div class="contact-icon">
                    <img :src="'/frontimages/icon/phone.png'" alt="Generic placeholder image" />
                    <h6>Contact Us</h6>
                  </div>
                  <div class="media-body">
                    <p>{{getDetail.contact_phone}}</p>
                  </div>
                </li>
                <li>
                  <div class="contact-icon">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <h6>Address</h6>
                  </div>
                  <div class="media-body">
                    <p v-html="getDetail.comp_address"></p>
                  </div>
                </li>
                <li>
                  <div class="contact-icon">
                    <img :src="'/frontimages/icon/email.png'" alt="Generic placeholder image" />
                    <h6>Email</h6>
                  </div>
                  <div class="media-body">
                    <p>{{getDetail.contact_email}}</p>
                  </div>
                </li>
               
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form class="theme-form" @submit.prevent="contactfrom" method="post">
              <div v-if="errors.length">
                  <ul class="validation-error mb-3">
                    <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
                  </ul>
                </div>
              <div class="form-row">
                <div class="col-md-6">
                  <label for="fname">First Name</label>
                  <input
                    type="text"
                    class="form-control !isEmpty(errors) && !conInput.fname
                            ? 'form-control border-danger'
                            : 'form-control' "
                      id="fname"
                      v-model="conInput.fname"
                      placeholder="First Name"
                      name="fname"
                    
                  />
                  <p class="text-danger" v-if="
                      errors.fname.length > 0 && !conInput.fname
                  " v-for="fname in errors.fname">
                      {{ fname }}
                  </p> 
                </div>
                <div class="col-md-6">
                  <label for="lname">Last Name</label>
                    <input
                      type="text"
                      class="form-control !isEmpty(errors) && !conInput.lname
                            ? 'form-control border-danger'
                            : 'form-control' "
                      id="lname"
                      v-model="conInput.lname"
                      placeholder="Last Name"
                      name="lname"
                      
                    />
                    <p class="text-danger" v-if="
                        errors.lname.length > 0 && !conInput.lname
                    " v-for="lname in errors.lname">
                        {{ lname }}
                    </p> 
                </div>
                <div class="col-md-6">
                  <label for="mobile">Phone number</label>
                  <input
                    type="tel"
                    class="form-control !isEmpty(errors) && !conInput.mobile
                            ? 'form-control border-danger'
                            : 'form-control' "
                    id="mobile"
                    v-model="conInput.mobile"
                    placeholder="Enter your number"
                    name="mobile"
                    
                  />
                  <p class="text-danger" v-if="
                        errors.mobile.length > 0 && !conInput.mobile
                    " v-for="mobile in errors.mobile">
                        {{ mobile }}
                    </p>
                </div>
                <div class="col-md-6">
                  <label for="email">Email</label>
                  <input
                    type="text"
                    class="form-control !isEmpty(errors) && !conInput.email
                            ? 'form-control border-danger'
                            : 'form-control' "
                    id="email"
                    v-model="conInput.email"
                    placeholder="Email"
                    name="email"
                    
                  />
                  <p class="text-danger" v-if="
                        errors.email.length > 0 && !conInput.email
                    " v-for="email in errors.email">
                        {{ email }}
                  </p>
                </div>
                <div class="col-md-12">
                  <label for="body">Write Your Message</label>
                  <textarea
                    class="form-control !isEmpty(errors) && !conInput.body
                            ? 'form-control border-danger'
                            : 'form-control' "
                    placeholder="Write Your Message"
                    id="body"
                    v-model="conInput.body"
                    name="body"
                    rows="6"
                  ></textarea>
                  <p class="text-danger" v-if="
                        errors.body.length > 0 && !conInput.body
                    " v-for="body in errors.body">
                        {{ body }}
                  </p>
                </div>
                <div class="col-md-12">
                  <input
                  type="submit"
                  class="btn btn-solid"
                  value="Send Your Message"
                >
                </div>
              </div>
            </form>
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
      Header,
		Footer,
        Breadcrumbs,
    },
    data() {
        return { 
                pageLoading: false,
                getDetail: {},
                imageSrc: "",
                errors: [],
                conInput: {
                    fname: "",
                    lname: "",
                    email: "",
                    mobile: "",
                    body: ""
                },
                meta: {},
        };
    },
    created() {
        this.getContactUsDetail();
        this.getMeta();
    },
    methods: {
        async getContactUsDetail() {
            let dataObj = {};
            let contactData = await this.$root.getFrontData(dataObj, `/api/company_param`);
            
            this.getDetail = contactData.data.data[0];
            //console.log(this.getDetail);
            this.imageSrc = contactData.data.url;
        },
        async getMeta() {
            let dataObj = {
                'meta_page': 'contactus',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
        },
        contactfrom() { 
              this.pageLoading = true;  
            this.$root.getFrontData(this.conInput, `/api/contactus`)
                .then(res => {
                    Vue.$toast.open({
                        message: res.data.message,
                        position: 'top-right',
                        type: 'success',
                        duration: 3000,
                        dismissible: false,
                    });
                    
                     this.pageLoading = false;
                }).catch(error => {
                  console.dir(error);
                let res = JSON.parse(error.request.response);                                
                if (res.status == "error") {
                    this.errors = JSON.parse(error.request.response).validation_errors;
                } else {
                    Vue.$toast.open({
                        message: "Failed to Contact Us",
                        position: 'top-right',
                        type: 'warning',
                        duration: 3000,
                        dismissible: false,                        
                    });
                }
                 this.pageLoading = false;
            })
        },
   
    },
    mounted() {},
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
};
</script>
<style>
.map p {
    height: 100%;
}
</style>