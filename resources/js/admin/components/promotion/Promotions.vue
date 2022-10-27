<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Promotions" btnRoute="add_promotion" btnName="Add Promotion" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th>Offer</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="promotion in promotions" :key="promotion.id">
                        <td>{{ promotion.id }}</td>
                        <td>{{ promotion.name }}</td>
                        <td>{{ promotion.promotionpercent }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=promotion_image_url+promotion.image /></td>
                        <td class="text-center">
                            <StatusBadge :status="promotion.status" />

                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_promotion', params: { id: promotion.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            promotions: [],
            promotion_image_url: "",
        }
    },
    created() {
        this.getPromotions();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getPromotions() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/promotions');
            this.promotion_image_url = data[0].url;
            this.promotions = data[0].data;
            this.loading = false;
        },
    }
}
</script>

<style scoped>
.img-thumbnail {
    max-height: 50px;
}
</style>
