<template>
    <div>
        <Header />
        <Breadcrumbs title="Faq" />
        <section class="faq-section section-b-space">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="accordion theme-accordion" id="accordionExample">
                  <b-card no-body class="mb-1" v-for="(item, index) in items" :key="index">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                      <b-button block href="#" v-b-toggle="'accordion-' + index" variant="info" v-html="item.faq_question"></b-button>
                    </b-card-header>
                    <b-collapse :id="'accordion-' + index" visible accordion="my-accordion" role="tabpanel">
                      <b-card-body>
                        <b-card-text>
                          <p v-html="item.faq_answer"></p>
                        </b-card-text>
                      </b-card-body>
                    </b-collapse>
                  </b-card>
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
          Header,
		Footer,
    Breadcrumbs
    },
    data() {
        return {
             items: [],
             meta: {},
        };
    },
    created() {
        this.getAboutUsDetail();
        this.getMeta();
    },
    methods: {
        async getAboutUsDetail() {
            let dataObj = {};
            let faqData = await this.$root.getFrontData(dataObj, `/api/faq_param`);
            this.items = faqData.data.data;
          //  console.log(this.items);
        },
        async getMeta() {
            let dataObj = {
                'meta_page': 'about',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
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
