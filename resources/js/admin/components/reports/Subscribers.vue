<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <div class="card-body">
            <h3>Subscribers </h3>
            <form id="reportForm" class="form-group" @submit.prevent="getSubscribers($event)">
                <div class="row">
                    <div class="col-lg-2">
                        <label>From</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="subscribeSearch.start_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>To</label>
                        <datepicker format="yyyy-MM-dd" input-class="form-control" placeholder="Select Date" v-model="subscribeSearch.end_date"></datepicker>
                    </div>
                    <div class="col-lg-2">
                        <label>Email</label>
                        <input type="text" class="form-control" placeholder="Email" v-model="subscribeSearch.email" />
                    </div>
                    <div class="col-lg-2">
                        <input value="Show Report" type="submit" name="btnsubmit" class="forms_button_e btn btn-primary" style="margin-top: 28px;" id="btn-filter">
                    </div>
                </div>
            </form>

            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />

            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" v-if="allSubscribers.length > 0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Subscribe Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscriber in allSubscribers" :key="subscriber.id">
                        <td>{{ subscriber.id }}</td>
                        <td>{{ subscriber.email }}</td>
                        <td>{{ new Date(subscriber.created_at).toLocaleDateString() }}</td>
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
            allSubscribers: [],
            filter: "",
            subscribeSearch: {
                start_date: "",
                end_date: "",
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
        getSubscribers() {
            this.subscribeSearch.start_date = this.formatDate(this.subscribeSearch.start_date);
            this.subscribeSearch.end_date = this.formatDate(this.subscribeSearch.end_date);
            this.loading = true;
            this.$root.addData(this.subscribeSearch, '/api/user/report/suscribe').then(response => {
                this.allSubscribers = response.data.data;
                this.loading = false;
                console.dir(response)
            }).catch(error => {
                let res = JSON.parse(error.request.response);
                console.dir(res);
            });
        }
    },
};
</script>
