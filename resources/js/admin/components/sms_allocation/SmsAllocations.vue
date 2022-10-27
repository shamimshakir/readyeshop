<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="SMS Allocations"
                btnRoute="add_sms_allocation"
                btnName="Add New"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="allocation in smsAllocations" :key="allocation.id">
                        <td>{{ allocation.id }}</td>
                        <td>{{ allocation.name }}</td>
                        <td>{{ allocation.allocate_ammount }}</td>
                        <td>{{ allocation.allocation_date }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CardHeader from "../basics/CardHeader";
    export default {
        components: {
            CardHeader,
        },
        data() {
            return {
                loading:false,
                smsAllocations: [],
            }
        },
        created() {
            this.getsmsAllocations();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getsmsAllocations() {
                this.loading = true;
                this.smsAllocations = await this.$root.getAllData('/api/user/smsallocations');
                this.loading = false;
            },
        }
    }
</script>
