<template>
<div>
    <Header />
    <Breadcrumbs title="Order Track" />
    <section class="about-page section-b-space">
        <div class="container">
            <article class="card">
                <header class="card-header"> My Orders / Tracking </header>
                <div class="card-body">
                    <h6>Order ID: {{ $route.params.orderno }}</h6>
                    <article class="card">
                        <div class="card-body row">
                            <div class="col"> <strong>Estimated Delivery time:</strong> <br>29 nov 2019 </div>
                            <div class="col"> <strong>Shipping BY:</strong> <br> BLUEDART, | <i class="fa fa-phone"></i> +1598675986 </div>
                            <div class="col"> <strong>Status:</strong> <br> Picked by the courier </div>
                            <div class="col"> <strong>Tracking #:</strong> <br> BD045903594059 </div>
                        </div>
                    </article>
                    <div class="track">
                        <div class="step" v-bind:class="{active: checkDone(odsts.id)}" v-for="odsts in sortedOrdeerStatuses">
                            <span class="icon">
                                <i :class="odsts.icon"></i>
                            </span>
                            <span class="text">{{ odsts.ord_status }}</span>
                        </div>
                    </div>
                    <hr>
                    <ul class="row">
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/iDwDQ4o.png" class="img-sm border"></div>
                                <figcaption class="info align-self-center">
                                    <p class="title">Dell Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$950 </span>
                                </figcaption>
                            </figure>
                        </li>
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/tVBy5Q0.png" class="img-sm border"></div>
                                <figcaption class="info align-self-center">
                                    <p class="title">HP Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$850 </span>
                                </figcaption>
                            </figure>
                        </li>
                        <li class="col-md-4">
                            <figure class="itemside mb-3">
                                <div class="aside"><img src="https://i.imgur.com/Bd56jKH.png" class="img-sm border"></div>
                                <figcaption class="info align-self-center">
                                    <p class="title">ACER Laptop with 500GB HDD <br> 8GB RAM</p> <span class="text-muted">$650 </span>
                                </figcaption>
                            </figure>
                        </li>
                    </ul>
                    <hr> <a href="#" class="btn btn-warning" data-abc="true"> <i class="fa fa-chevron-left"></i> Back to orders</a>
                </div>
            </article>
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
            orders__statuses: [],
            ordersTrackInfo: {},
            orderHistories: [],
        };
    },
    created() {
        this.getOrderTrackStatus();
        console.log(this.sortedOrdeerStatuses)
    },
    computed: {
        sortedOrdeerStatuses() {
            return this.orders__statuses.filter(ordrSts => {
                if( ordrSts.id == 4 && !this.checkDone(ordrSts.id)){
                    return false;
                }else if( ordrSts.id == 5 && !this.checkDone(ordrSts.id)) {
                    return false;
                }else{
                    return true;
                }
            }).sort((a, b) =>  a.sl - b.sl);
        }
    },
    methods: {
        async getOrderTrackStatus() {
            let dataObj = {
                order_no: this.$route.params.orderno
            };
            let trackData = await this.$root.getDetailsData(dataObj, `/api/customer/ordertrack`);
            this.ordersTrackInfo = trackData.data.data[0];
            this.orderHistories = trackData.data.data[0].orderhistorys;
            this.orders__statuses = trackData.data.odstatus;
        },
        checkDone(stsId){
            return this.orderHistories.some(his => stsId === his.orderhistorystatus.id)
        }
    },
    mounted() {},
};
</script>
