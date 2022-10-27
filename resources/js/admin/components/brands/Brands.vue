<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Brands" btnRoute="add_brand" btnName="Add Brand" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Others Name</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in brands" :key="brand.id">
                        <td>{{ brand.id }}</td>
                        <td>{{ brand.brand_display }}</td>
                        <td>{{ brand.other_band_name }}</td>
                        <td class="text-center">
                            <StatusBadge :status="brand.status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_brand', params: { id: brand.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            loading: false,
            brands: [],
        }
    },
    created() {
        this.getBrands();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getBrands() {
            this.loading = true;
            this.brands = await this.$root.getAllData('/api/user/brands');
            this.loading = false;
        },
    }
}
</script>
