<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="Third Party App"
                btnRoute="add_third_party_auth"
                btnName="Add App"
                :menu_name="routeName"
            />
            <div class="card-body" style="overflow-x:auto;">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>                        
                        <th>Name</th>                        
                        <th>Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="tpauth in thirdpartyauths" :key="tpauth.id">
                        <td>{{ tpauth.name }}</td> 
                         <td class="text-center">
                            <StatusBadge :status="tpauth.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_third_party_auth', params: { id: tpauth.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            CardHeader,
            StatusBadge
        },
        data() {
            return {
                loading:false,
                thirdpartyauths: [],
            }
        },
        created() {
            this.getthirdpartyauths();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getthirdpartyauths() {
                this.loading = true;
                this.thirdpartyauths = await this.$root.getAllData('/api/user/thirdpartyauths');
                this.loading = false;
            },
        }
    }
</script>
