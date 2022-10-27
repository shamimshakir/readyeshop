<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="User Guides" btnRoute="add_user_guide" btnName="Add New" :menu_name="routeName"/>
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div class="videoCard" v-for="userguide in userguides" :key="userguide.id">
                <h5 class="d-flex justify-content-lg-between">
                    <span>{{ userguide.question }}</span>
                    <span><router-link :to="{name: 'edit_user_guide', params: { id: userguide.id }}" class="btn btn-info btn-sm">Edit</router-link></span>
                </h5>
                <div class="videoIframe" v-html="userguide.video"></div>
            </div>
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
            loading: false,
            userguides: [],
        }
    },
    created() {
        this.getuserguides();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getuserguides() {
            this.loading = true;
            this.userguides = await this.$root.getAllData('/api/user/userguides');
            this.loading = false;
        },
    }
}
</script>