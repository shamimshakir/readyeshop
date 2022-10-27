<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>SMS Log </h3>
            <form id="reportForm" class="form-group" @submit.prevent="searchSMS($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="smsSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="smsSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>Number</label>
                        <input type="text" class="form-control" placeholder="Number" v-model="smsSearch.number" />
                    </div>
                    <div class="col-lg-2">
                        <label>SMS Status</label>
                        <select v-model="smsSearch.sms_status" class="form-control">
                            <option value="true">True</option>
                            <option value="false">False</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="allSms.length > 0">
                <thead>
                    <tr>
                        <th>Mobile No</th>
                        <th>Return Message</th>
                        <th>SMS Status</th>
                        <th>Send Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sms in allSms" :key="sms.id">
                        <td>{{ sms.number }}</td>
                        <td>{{ sms.return_message }}</td>
                        <td>{{ sms.sms_status }}</td>
                        <td>{{ sms.date_time }}</td>
                    </tr>
                </tbody>
            </table>
            <div v-else class="mb-5 pt-5 pb-5"></div>
        </div>
    </div>
</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
export default {
    components: {
        Datepicker
    },
    data() {
        return {
            loading: false,
            allSms: [],
            filter: "",
            smsSearch: {
                start_date: "",
                end_date: "",
                sms_status: "true",
            },
        }
    },
    created() {

    },
    mounted() {

    },
    methods: {
        formatDate(data) {
            if (data) {
                return new Date(data).toISOString().slice(0, 10);
            } else {
                return "";
            }
        },
        searchSMS() {
            this.smsSearch.start_date = this.formatDate(this.smsSearch.start_date);
            this.smsSearch.end_date = this.formatDate(this.smsSearch.end_date);
            this.loading = true;
            this.$root.addData(this.smsSearch, '/api/user/smslogs/search').then(response => {
                this.allSms = response.data.data;
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
