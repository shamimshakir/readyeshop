<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Customers" btnRoute="add_customer" btnName="Add Customer" :menu_name="routeName" />
        <div class="card-body">
            <div class="filterCustomer">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <p class="mb-0">Search Customer</p>
                            <input type="text" class="form-control border border-secondary" v-model="filter" placeholder="Search" @keydown="$event.stopImmediatePropagation()" />
                        </div>
                    </div>
                </div>
            </div>
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div class="col-xs-12 table-responsive">
                <datatable class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" :columns="columns" :data="customers" :filter="filter" :per-page="25"></datatable>

                <datatable-pager class="datatablePagination" v-model="page"></datatable-pager>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import StatusBadge from "../basics/StatusBadge";
import editButton from "../basics/editButton";
export default {
    components: {
        CardHeader,
        StatusBadge,
        editButton
    },
    data() {
        return {
            loading: false,
            customers: [],
            filter: "",
            columns: [{
                    label: "#SL",
                    field: "id",
                    align: 'center',
                },
                {
                    label: "First Name",
                    field: "firstname"
                },
                {
                    label: "Phone",
                    field: "phone"
                },
                {
                    label: "Email",
                    field: "email"
                },
                {
                    label: "Address",
                    field: "address"
                },
                {
                    label: "Verify Status",
                    align: 'center',
                    representedAs: ({
                        varified_status
                    }) => {
                        if (varified_status == 1) {
                            return `<span class="badge badge-success">Varified</span>`;
                        } else {
                            return `<span class="badge badge-danger">Unvarified</span>`;
                        }
                    },
                    interpolate: true,
                },
                {
                    label: "Status",
                    align: 'center',
                    representedAs: ({
                        user_stat
                    }) => {
                        if (user_stat == 1) {
                            return `<span class="badge badge-success">Active</span>`;
                        } else {
                            return `<span class="badge badge-danger">Inactive</span>`;
                        }
                    },
                    interpolate: true,
                },
                {
                    field: "id",
                    component: editButton,
                    label: "Action",
                    align: 'center',
                    class: "edit_customer"
                },
            ],
            page: 1,
        };
    },
    created() {
        this.getCustomers();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getCustomers() {
            this.loading = true;
            this.customers = await this.$root.getAllData('/api/user/customers');
            this.loading = false;
        },
    },
};
</script>
