<template>
<div>
    <Header />
    <Breadcrumbs title="collection" />
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <vue-loaders-ball-clip-rotate-multiple v-if="pageLoading" scale="1.5" color="#000" />
            <div class="container">
                <div class="row" v-bind:class="{ lessOpacity: pageLoading }">
                    <div class="col-lg-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="filter-main-btn" @click="filter = !filter">
                                        <span class="filter-btn btn btn-theme">
                                            <i class="fa fa-filter" aria-hidden="true"></i> Filter
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="collection-filter" :class="{ 'openFilterbar' : filter }">
                                <!-- side-bar colleps block stat -->
                                <div class="collection-filter-block">
                                    <div class="collection-mobile-back">
                                        <span class="filter-back" @click="filter = !filter">
                                            <i class="fa fa-angle-left" aria-hidden="true"></i> back
                                        </span>
                                    </div>
                                    <!-- brand filter start -->
                                    <div v-if="companyinfo.brand_filtering==1">
                                        <div class="collection-collapse-block open" v-if="brands.length">
                                            <h3 class="collapse-block-title" v-b-toggle.brand>brand</h3>
                                            <b-collapse id="brand" visible accordion="myaccordion1" role="tabpanel">
                                                <div class="collection-collapse-block-content">
                                                    <div class="collection-brand-filter">
                                                        <div class="custom-control custom-checkbox collection-filter-checkbox" v-for="(brand,index) in brands" :key="index">
                                                            <input type="checkbox" class="custom-control-input" :value="brand.id" :id="'brand'+brand.id" v-model="selectedBrands" />
                                                            <label class="custom-control-label" v-bind:for="'brand'+brand.id">{{brand.brand_display}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>
                                    <!-- color filter start here -->
                                    <div v-if="companyinfo.color_filtering==1">
                                        <div class="collection-collapse-block open" v-if="allColors.length">
                                            <h3 class="collapse-block-title" v-b-toggle.colors>colors</h3>
                                            <b-collapse id="colors" visible accordion="myaccordion2" role="tabpanel">
                                                <div class="collection-collapse-block-content">
                                                    <div class="collection-brand-filter color-filter">
                                                        <div class="custom-control custom-checkbox collection-filter-checkbox" v-for="(color,index) in allColors" :key="index">
                                                            <input type="checkbox" class="custom-control-input" :value="color.id" :id="'color'+color.id" v-model="selectedColors" />
                                                            <span :class="color.color_name" v-bind:style="{ 'background-color' : color.color_name}"></span>
                                                            <label class="custom-control-label" v-bind:for="'color'+color.id">{{color.color_name}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>
                                    <!-- size filter start here -->
                                    <div v-if="sizeParam.parameter_status==1">
                                        <div class="collection-collapse-block open" v-if="allSizes.length">
                                            <h3 class="collapse-block-title" v-b-toggle.size>Size</h3>
                                            <b-collapse id="size" visible accordion="myaccordion3" role="tabpanel">
                                                <div class="collection-collapse-block-content">
                                                    <div class="color-selector">
                                                        <div class="collection-brand-filter">
                                                            <div class="custom-control custom-checkbox collection-filter-checkbox" v-for="(size,index) in allSizes" :key="index">
                                                                <input type="checkbox" class="custom-control-input" :value="size.id" :id="'size'+size.id" v-model="selectedSizes" />
                                                                <label class="custom-control-label" v-bind:for="'size'+size.id">{{size.size_display}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>

                                    <!-- All filter start -->
                                    <div v-if="allFilters.length" v-for="(allFilter,indexs) in allFilters" :key="indexs">
                                        <div class="collection-collapse-block open" v-if="allFilter.filteroptions.length">
                                            <h3 class="collapse-block-title" v-b-toggle="'filter-'+allFilter.id">{{allFilter.name}}</h3>
                                            <b-collapse :id="'filter-'+allFilter.id" visible :accordion="'myaccordion'+allFilter.id" :role="'tabpane'+allFilter.id">
                                                <div class="collection-collapse-block-content">
                                                    <div class="color-selector">
                                                        <div class="collection-brand-filter">
                                                            <div class="custom-control custom-checkbox collection-filter-checkbox" v-for="(option,index) in allFilter.filteroptions" :key="index">
                                                                <input type="checkbox" class="custom-control-input" :value="option.id" :id="'filter'+option.id" v-model="selectedFilters" />
                                                                <label class="custom-control-label" v-bind:for="'filter'+option.id">{{option.option_name}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>
                                    <!-- All filter end -->
                                    <!-- price filter start here -->
                                    <div v-if="companyinfo.price_filtering==1">
                                        <div class="collection-collapse-block border-0 open">
                                            <h3 class="collapse-block-title" v-b-toggle.price>price</h3>
                                            <b-collapse id="price" visible accordion="myaccordion4" role="tabpanel">
                                                <div class="collection-collapse-block-content">
                                                    <div class="collection-brand-filter price-rangee-picker">
                                                        <vue-slider v-model="priceRange" :min="0" :max="1000000" ref="slider">
                                                        </vue-slider>
                                                    </div>
                                                </div>
                                            </b-collapse>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- silde-bar colleps block end here -->
                            <!-- side-bar banner start here -->
                            <!-- <div class="collection-sidebar-banner">
                                <a href="#">
                                    <img src="https://lh3.googleusercontent.com/e4G8DqguXs-60CLOeanDqSiuCDuR0IUll2g8BTspDEi8ewM7cjmPj3jBizeweC_8xos163NaHwHn58qF=w1080-h608-p-no-v0" class="img-fluid" />
                                </a>
                            </div> -->
                            <!-- side-bar banner end here -->
                        </div>
                    </div>
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- <ul class="product-filter-tags">
                                        <li class="mr-1" v-for="(tag,index) in allfilters" :key="index">
                                            <a href="javascript:void(0)" class="filter_tag">{{tag}}<i class="ti-close" @click="removeTags(tag)"></i></a>
                                        </li>
                                        <li class="clear_filter" v-if="allfilters.length > 0"><a href="javascript:void(0)" class="clear_filter" @click="removeAllTags()">Clear all</a></li>
                                    </ul> -->
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product-filter-content">
                                                        <div class="collection-view">
                                                            <ul>
                                                                <li @click="gridView()">
                                                                    <i class="fa fa-th grid-layout-view"></i>
                                                                </li>
                                                                <li @click="listView()">
                                                                    <i class="fa fa-list-ul list-layout-view"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="collection-grid-view">
                                                            <ul>
                                                                <li>
                                                                    <img :src="'/frontimages/icon/2.png'" @click="grid2()" class="product-2-layout-view" />
                                                                </li>
                                                                <li>
                                                                    <img :src="'/frontimages/icon/3.png'" @click="grid3()" class="product-3-layout-view" />
                                                                </li>
                                                                <li>
                                                                    <img :src="'/frontimages/icon/4.png'" @click="grid4()" class="product-4-layout-view" />
                                                                </li>
                                                                <li>
                                                                    <img :src="'/frontimages/icon/6.png'" @click="grid6()" class="product-6-layout-view" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-page-filter">
                                                            <select @change="onChangeSort($event)">
                                                                <option value="all">Sorting Items</option>
                                                                <option value="low">price, low to high</option>
                                                                <option value="high">price, high to low</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid" :class="{'list-view':listview == true}">
                                            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#000" />
                                            <div class="row" v-bind:class="{ lessOpacity: loading }">
                                                <div class="col-sm-12">
                                                    <div class="text-center section-t-space section-b-space" v-if="filteredProducts.length == 0">
                                                        <img :src='"frontimages/empty-search.jpg"' class="img-fluid" alt />
                                                       <!--  <h3 class="mt-3">Sorry! Couldn't find the product you were looking For!!!</h3> -->
                                                        <div class="col-12 mt-3">
                                                            <router-link :to="{ path: '/'}" class="btn btn-solid">continue shopping</router-link>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-grid-box" :class="{'col-lg-3':col4 == true, 'col-lg-4':col3 == true, 'col-lg-6':col2 == true, 'col-lg-2':col6 == true, 'col-lg-12':listview == true}" v-for="(product,index) in filteredProducts" :key="index">
                                                    <div class="product-box">
                                                        <productBox1 :product="product" :index="index" :image-src="imageSrc" @openquickview="showQuickview" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-pagination mb-0">
                                            <div class="theme-paggination-block">
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <nav aria-label="Page navigation">
                                                            <ul class="pagination">
                                                                <li class="page-item" :class="{'disable': current_page == 1 }">
                                                                    <a class="page-link" href="javascript:void(0)" @click="updatePaginate(current_page - 1)">
                                                                        <span aria-hidden="true">
                                                                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <!-- <li class="page-item" v-for="(page_index, index) in this.pages" :key="index" :class="{'active': page_index == current}">
                                                                    <a class="page-link" href="javascrip:void(0)" @click.prevent="updatePaginate(page_index)">{{ page_index }}</a>
                                                                </li> -->
                                                                <li class="page-item" :class="{'disable': current_page == last_page }">
                                                                    <a class="page-link" href="javascript:void(0)" @click="updatePaginate(current_page + 1)">
                                                                        <span aria-hidden="true">
                                                                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        <div class="product-search-count-bottom">
                                                            <h5>Showing Products {{fromItem}}-{{toItem}} of {{ totalColumns }} Result</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <Footer />
</div>
</template>

<script>
import Breadcrumbs from '../components/widgets/breadcrumbs'
import productBox1 from '../components/product-box/product-box1'
import quickviewModel from '../components/widgets/quickview'
import Header from "../components/header/header1";
import Footer from "../components/footer/footer1";
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'
import _ from "lodash"
export default {
    components: {
        Header,
		Footer,
        Breadcrumbs,
        productBox1,
        quickviewModel,
        VueSlider
    },
    data() {
        return {
            loading: false,
            pageLoading: false,
            allProducts: [],
            filteredProducts: [],
            brands: [],
            allColors: [],
            allSizes: [],
            allFilters: [],
            imageSrc: "",
            priceRange: [0, 1000000],
            selectedBrands: [],
            selectedColors: [],
            selectedSizes: [],
            selectedFilters: [],
            limit: 8,
            page: 1,
            totalColumns: null,
            last_page: null,
            col2: false,
            col3: false,
            col4: true,
            col6: false,
            listview: false,
            current_page: null,
            fromItem: null,
            toItem: null,
            filter: false,
            showquickviewmodel: false,
            showcomparemodal: false,
            showcartmodal: false,
            quickviewproduct: {},
            comapreproduct: {},
            cartproduct: {},
            dismissSecs: 5,
            dismissCountDown: 0,
            swiperOption: {
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                }
            },
            meta: {},
            catd: {},
            sizeParam: {},
        }
    },
    watch: {

    },
    computed: {
        companyinfo() {        
          return this.$store.state.companyInfo;
        }, 
        companyimg() {
          return this.$store.getters.companyImg;
        },
    },
    mounted() {

    },
    created() {
        this.getShopPageInfos();
        this.getMeta();
        this.getCatData();
        this.getSizeParamaters();
    },
    watch: {
        selectedBrands: _.debounce(function () {
            this.getFilteredProducts()
        }, 200),
        selectedColors: _.debounce(function () {
            this.getFilteredProducts()
        }, 200),
        selectedSizes: _.debounce(function () {
            this.getFilteredProducts()
        }, 200),
        priceRange: _.debounce(function () {
            this.getFilteredProducts()
        }, 200),
        selectedFilters: _.debounce(function () {
            this.getFilteredProducts()
        }, 200),
        "$route.query.catid": {
          handler: function (value) {
            this.getShopPageInfos()
            this.getCatData()
            this.getMeta()    
          },
          deep: true,
          immediate: true,
        },
    },
    methods: {
        async getMeta() {
            let dataObj = {
                'meta_page': 'catagory',
                'status': '1',
            };
            let metaData = await this.$root.getFrontData(dataObj, `/api/meta/param`);
            this.meta = metaData.data.data[0];
        },
        async getCatData() {
            let dataObj = {
                'id': this.$route.query.catid,
                'status': '1',
            };
            let catData = await this.$root.getFrontData(dataObj, `/api/cat/name`);
            this.catd = catData.data.data[0];
            console.log(this.catd);

        },
        async getBrands() {
            let dataObj = {};
            return await this.$root.getFrontData(dataObj, `/api/brand_param`);
        },
        async getColors() {
            let dataObj = {};
            return await this.$root.getFrontData(dataObj, `/api/color_param`);
        },
        async getSizes() {
            let dataObj = {};
            return await this.$root.getFrontData(dataObj, `/api/size_param`);
        },
        async getProducts() {
            let dataObj = {'status': 1};
            dataObj.category = [];
            dataObj.category.push(this.$route.query.catid);
            return await this.$root.getFrontData(dataObj, `/api/product_param?page=${this.page}&limit=${this.limit}`);
        },
        async getShopPageInfos() {
            this.pageLoading = true;
            Promise.all([
                this.getColors(),
                this.getBrands(),
                this.getSizes(),
                this.getProducts(),
                this.getFilterOptions(),
            ]).then((res) => {
                this.allColors = res[0].data.data;
                this.brands = res[1].data.data;
                this.allSizes = res[2].data.data;
                this.filteredProducts = res[3].data.data.data;
                this.totalColumns = res[3].data.data.total;
                this.current_page = res[3].data.data.current_page;
                this.last_page = res[3].data.data.last_page;
                this.fromItem = res[3].data.data.from;
                this.toItem = res[3].data.data.to;
                this.imageSrc = res[3].data.url;
                this.allFilters=res[4].data.data;
                this.$store.commit("CHANGE_LEFT_SIDEBAR", false);
                this.pageLoading = false;
            });
        },
        async getFilteredProducts(hitPage = null) {
            let page = hitPage ? hitPage : this.page;
            let apiUrl = `/api/product_param?page=${page}&limit=${this.limit}`;
            this.loading = true;
            let dataObj = {};
            dataObj.brand = [];
            dataObj.color = [];
            dataObj.size = [];
            dataObj.status = '1';
            dataObj.price_start = this.priceRange[0];
            dataObj.price_end = this.priceRange[1];
            dataObj.category = [];
            dataObj.category.push(this.$route.query.catid);
            this.selectedBrands.forEach((brand, index) => {
                dataObj.brand[index] = brand;
            });
            this.selectedColors.forEach((color, index) => {
                dataObj.color[index] = color;
            });
            this.selectedSizes.forEach((size, index) => {
                dataObj.size[index] = size;
            });
            this.selectedFilters.forEach((filter, index) => {
                dataObj.filter[index] = filter;
            });
            this.filteredProducts = [];
            let products = await this.$root.getFrontData(dataObj, apiUrl);
            let filterData = products.data.data;
            this.filteredProducts = filterData.data;
            this.totalColumns = filterData.total;
            this.current_page = filterData.current_page;
            this.last_page = filterData.last_page;
            this.fromItem = filterData.from;
            this.toItem = filterData.to;
            this.loading = false;
        },
        onChangeSort(event) {
            let targetVal = event.target.value;
            if (targetVal === 'low') {
                this.filteredProducts.sort((a, b) => parseFloat(a.pd_price) - parseFloat(b.pd_price));
            } else if (targetVal === 'high') {
                this.filteredProducts.sort((a, b) => parseFloat(b.pd_price) - parseFloat(a.pd_price));
            }
        },
        gridView() {
            this.col4 = true
            this.col2 = false
            this.col3 = false
            this.col6 = false
            this.listview = false
        },
        listView() {
            this.listview = true
            this.col4 = false
            this.col2 = false
            this.col3 = false
            this.col6 = false
        },
        grid2() {
            this.col2 = true
            this.col3 = false
            this.col4 = false
            this.col6 = false
            this.listview = false
        },
        grid3() {
            this.col3 = true
            this.col2 = false
            this.col4 = false
            this.col6 = false
            this.listview = false
        },
        grid4() {
            this.col4 = true
            this.col2 = false
            this.col3 = false
            this.col6 = false
            this.listview = false
        },
        grid6() {
            this.col6 = true
            this.col2 = false
            this.col3 = false
            this.col4 = false
            this.listview = false
        },
        updatePaginate(pageNum) {
            if (pageNum > 0 && pageNum <= this.last_page) {
                this.getFilteredProducts(pageNum);
            }
        },
        showQuickview(item, productData) {
            this.showquickviewmodel = item
            this.quickviewproduct = productData
        },
        async getSizeParamaters() {
            let dataObj = {
                'parameter_name': 'size'
            };
            let parameterData = await this.$root.getFrontData(dataObj, '/api/parameter_param');
            this.sizeParam = parameterData.data.data[0];
        },
        async getFilterOptions() {
            let dataObj = {
                status:1
            };
            return await this.$root.getFrontData(dataObj, `/api/productfilter_param`);
        },
    },
    metaInfo() {
        return {
            title: this.meta.meta_name + this.catd.cat_name ,
            meta: [
                { name: 'description', content: this.catd.meta_description },
                { name: 'keywords', content: this.catd.meta_keyword },
                { property: 'og:title', content: this.catd.meta_description },
                { property: 'og:site_name', content: this.meta.meta_name + this.catd.cat_name },
                { property: 'og:type', content: 'website' },
                { name: 'robots', content: 'index,follow' }
            ]
        }
    },
}
</script>
