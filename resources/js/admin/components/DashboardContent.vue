<template>
    <div class="col-lg-12">
        <hr>
        <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-cube-outline float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">New Orders</p>
                    <p class=""># {{orderTop.New_Order}}<br>৳ {{orderTop.New_total}}</p>
                    <!--<span class="badge badge-info"> +11% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-success">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-buffer float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Delivered</p>
                    <p class=""># {{orderTop.Delivered}}<br>৳ {{orderTop.Delivered_total}}</p>
                    
                    <!--<span class="badge badge-danger"> -29% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-danger">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-tag-text-outline float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Cancelled</p>
                    <p class=""># {{orderTop.Cancelled}}<br>৳ {{orderTop.Cancelled_total}}</p>
                    <!--<span class="badge badge-warning"> 0% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-warning">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-briefcase-check float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Returned</p>
                    <p class=""># {{orderTop.Returned}}<br>৳ {{orderTop.Returned_total}}</p>
                    <!--<span class="badge badge-info"> +89% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-warning">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-cube-outline float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Purchase</p>
                    <p class="">৳ {{purchaseData.ptotal}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-success">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-cube-outline float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Collection</p>
                    <p class="">৳ {{collectionData.tcollection}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-muted">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-buffer float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Stock</p>
                    <p class=""># {{productData.qtys}}<br>৳ {{productData.total}}</p>                   
                    <!--<span class="badge badge-danger"> -29% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-tag-text-outline float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Number OF Client</p>
                    <p class=""># {{totalClient.CustomerTotal}}<br></p>
                    <!--<span class="badge badge-warning"> 0% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card mini-stat bg-primary">
                <div class="card-body mini-stat-img">
                  <div class="mini-stat-icon"> <i class="mdi mdi-briefcase-check float-right"></i> </div>
                  <div class="text-white">
                    <p class="text-uppercase mb-3">Client With Order</p>                    
                    <p class="mb-4">#<br></p>                    
                    <!--<span class="badge badge-info"> +89% </span> <span class="ml-2">From previous period</span>--> 
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Status Chart</h4> 
                        <div class="row">
                            <status-chart></status-chart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Sale Report</h4> 
                        <div class="row">
                            <sale-chart></sale-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">  
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Collection Report</h4> 
                        <div class="row">
                            <collection-chart></collection-chart>
                        </div>
                    </div>
                </div>
            </div>          
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Purchase Report</h4> 
                        <div class="row">
                            <purchase-chart></purchase-chart>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <div class="row"> 
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Best Sale Product</h4> 
                        <div class="row">
                            <best-sale-chart></best-sale-chart>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-lg-6">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Best Client</h4> 
                        <div class="row">
                            <best-client-chart></best-client-chart>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-lg-6" style="max-height: 470px; overflow-y: scroll;">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">SMS LOG</h4> 
                        <div class="row ">
                            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                            <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="smslog.length > 0" >
                                <thead>
                                    <tr>
                                        <th>Mobile No</th>
                                        <th>Return Message</th>
                                        <th>SMS Status</th>
                                        <th>Send Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sms in smslog" :key="sms.id">
                                        <td>{{ sms.number }}</td>
                                        <td style="word-break:break-all;">{{ sms.return_message }}</td>
                                        <td>{{ sms.sms_status }}</td>
                                        <td>{{ sms.date_time }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-else class="mb-5 pt-5 pb-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" style="max-height: 470px; overflow-y: scroll;">
                <div class="card m-b-30">
                    <div class="card-body">
                      <h4 class="mt-0 header-title">Email Log</h4> 
                        <div class="row ">
                            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                            <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="allEmail.length > 0">
                                <thead>
                                    <tr>
                                        <th>Email</th>                                        
                                        <th>Return Message</th>
                                        <th>Email Status</th>
                                        <th>Send Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="Email in allEmail" :key="Email.id">
                                        <td>{{ Email.email }}</td>           
                                        <td style="word-break:break-all;">{{ Email.return_message }}</td>
                                        <td>{{ Email.email_status }}</td>
                                        <td>{{ Email.date_time }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div v-else class="mb-5 pt-5 pb-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import SaleChart from './BarChart'
import BestClientChart from './BestClientChart'
import BestSaleChart from './BestSaleChart'
import PurchaseChart from './PurchaseChart'
import CollectionChart from './CollectionChart'

import StatusChart from './PieChart'
export default {
    components: {
      SaleChart,
      StatusChart,
      BestClientChart,
      BestSaleChart,
      PurchaseChart,
      CollectionChart
    },
    data() {
        return {
            loading: false,
            smslog: [],
            allEmail: [],
            orderTop: [],
            totalClient: [],
            purchaseData: [],
            productData: [],
            collectionData: [],
        }
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    created() {
        this.getSmss();
        this.getEmail();
        this.getTopbar();
    },
    methods: {
        async getSmss() {
            this.$root.addData({}, '/api/user/dashboard/sms').then(response => {
                this.smslog = response.data.data;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        },
        async getEmail() {           
            this.$root.addData("", '/api/user/dashboard/email').then(response => {
                this.allEmail = response.data.data;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        },
        async getTopbar() { 
            this.$root.addData("", '/api/user/dashboard/topbar').then(response => {
                this.orderTop = response.data.data[0];
                this.totalClient = response.data.data[1];         
                this.purchaseData = response.data.data[2];         
                this.productData = response.data.data[3];         
                this.collectionData = response.data.data[4];         
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    }
}
</script>
<style>
  p {
    margin-top: 0;
    margin-bottom: 0px;
  }
  .mb-3, .my-3 {
    margin-bottom: 2px!important;
  }
</style>