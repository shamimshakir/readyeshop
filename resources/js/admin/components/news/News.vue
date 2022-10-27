<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="News" btnRoute="add_news" btnName="Add News" :menu_name="routeName"  />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Title</th>
                        <th>Header</th>
                        <th>Details</th>
                        <th>Image</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sNews in news" :key="sNews.id">
                        <td>{{ sNews.id }}</td>
                        <td>{{ sNews.news_title }}</td>
                        <td>{{ sNews.news_header }}</td>
                        <td>{{ sNews.news_detail }}</td>
                        <td class="text-center"><img class="img-thumbnail" :src=url_image_url+sNews.news_image /></td>
                        <td class="text-center">
                            <StatusBadge :status="sNews.news_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_news', params: { id: sNews.id }}" class="btn btn-info btn-sm">Edit</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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
            news: [],
            url_image_url: "",
        }
    },
    created() {
        this.getNews();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getNews() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/news');
            this.url_image_url = data[0].url;
            this.news = data[0].data;
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
