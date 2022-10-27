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
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
  export default {
      components: {
        Header,
        Footer,
      },
    data(){
      return {
        payment: {},
      }
    },
    created() {
        this.showMessages();
        console.log(this.$route.params.messagetype)
    },
    methods: {
        async showMessages() {
            let dataObj = {};
            let data = await this.$root.getFrontData(dataObj, '/api/success');
        },
    }
  };
</script>
