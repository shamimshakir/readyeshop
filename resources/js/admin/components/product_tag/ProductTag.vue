<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Product Tag"
                btnRoute="add_producttag"
                btnName="Add Product Tag"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Details</th>

                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="producttag in producttags" :key="producttag.id">
                        <td>{{ producttag.id }}</td>
                        <td>{{ producttag.tag_name }}</td>
                        <td>{{ producttag.tag_label }}</td>
                        <td>{{ producttag.location_detail }}</td>
                        <td class="text-center">
                            <StatusBadge :status="producttag.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_producttag', params: { id: producttag.id }}" class="btn btn-info btn-sm">Edit</router-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CardHeader from "../basics/CardHeader";
    import StatusBadge from "../basics/StatusBadge";
    export default {
        components: {
            StatusBadge,
            CardHeader,
        },
        data() {
            return {
                loading:false,
                producttags: [],
            }
        },
        created() {
            this.getunits();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getunits() {
                this.loading = true;
                this.producttags = await this.$root.getAllData('/api/user/producttags');
                this.loading = false;
            },
        }
    }
</script>
