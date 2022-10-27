<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>Email Log </h3>
            <form id="reportForm" class="form-group" @submit.prevent="searchEmail($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="EmailSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="EmailSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Email" v-model="EmailSearch.email" />
                    </div>
                    <div class="col-lg-2">
                        <label>Email Status</label>
                        <select v-model="EmailSearch.email_status" class="form-control">
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

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="allEmail.length > 0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Email Body</th>
                        <th>Return Message</th>
                        <th>Email Status</th>
                        <th>Send Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="Email in allEmail" :key="Email.id">
                        <td>{{ Email.email }}</td>
                        <td>{{ Email.email_body }}</td>
                        <td>{{ Email.return_message }}</td>
                        <td>{{ Email.email_status }}</td>
                        <td>{{ Email.date_time }}</td>
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
            allEmail: [],
            filter: "",
            EmailSearch: {
                start_date: "",
                end_date: "",
                email_status: "true",
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
        searchEmail() {
            this.EmailSearch.start_date = this.formatDate(this.EmailSearch.start_date);
            this.EmailSearch.end_date = this.formatDate(this.EmailSearch.end_date);
            this.loading = true;
            this.$root.addData(this.EmailSearch, '/api/user/emaillogs/search').then(response => {
                this.allEmail = response.data.data;
                this.loading = false;
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
