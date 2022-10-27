<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Page Content"
                btnRoute="add_page_content"
                btnName="Add Page"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Page Title</th>
                        <th>Page Name</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="pageContent in pageContents" :key="pageContent.id">
                        <td>{{ pageContent.id }}</td>
                        <td>{{ pageContent.page_title }}</td>
                        <td>{{ pageContent.page_name }}</td>
                        <td class="text-center">
                            <StatusBadge :status="pageContent.active_status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_page_content', params: { id: pageContent.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                pageContents: [],
            }
        },
        created() {
            this.getpageContents();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getpageContents() {
                this.loading = true;
                this.pageContents = await this.$root.getAllData('/api/user/pagecontents');
                this.loading = false;
            },
        }
    }
</script>
