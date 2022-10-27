<template>
  <div>
    <Header />
    <Breadcrumbs v-bind:title="items.page_title" />
    <section class="faq-section section-b-space">
      <div class="container">
        <div class="row">
          <div class="col-sm-12" v-html="items.page_content"></div>
         
        </div>
      </div>
    </section>
    <Footer />
  </div>
</template>

<script>
import Breadcrumbs from "../components/widgets/breadcrumbs";
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
      items: {},
      meta: {},
    };
  },
  watch: {
    "$route.params.pagename": {
      handler: function (value) {
        this.getOthersDetail(value);
      },
      deep: true,
      immediate: true,
    },
  },
  created() {
    this.getOthersDetail(this.$route.params.pagename);
    this.getMeta();
  },
  methods: {
    async getOthersDetail(page) {
      let dataObj = {
        page_name: page,
      };

      let othersData = await this.$root.getFrontData(
        dataObj,
        `/api/pagecontent_param`
      );
      this.items = othersData.data.data[0];
      //console.log(this.items);
    },
    async getMeta() {
            let dataObj = {
                'meta_page': 'others',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
    },
  },
  mounted() {},
  metaInfo() {
    return {            
        title:  this.meta.meta_name + this.items.page_title, 
        meta: [
            { name: 'description', content:  this.meta.meta_content},
            { name: 'keywords', content:  this.meta.meta_type},
            { property: 'og:title', content: this.meta.meta_content},
            { property: 'og:site_name', content: this.meta.meta_name + this.items.page_title},
            {property: 'og:type', content: 'website'},    
            {name: 'robots', content: 'index,follow'} 
        ]
    }
  },
};
</script>
