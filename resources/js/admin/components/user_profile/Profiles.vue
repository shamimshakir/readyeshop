<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="User Profiles"
                btnRoute="add_user_profile"
                btnName="Add User"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Name</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="userprofile in userprofiles" :key="userprofile.id">
                        <td>{{ userprofile.id }}</td>
                        <td>{{ userprofile.profile_name }}</td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_user_profile', params: { id: userprofile.id }}" class="btn btn-info btn-sm">Edit</router-link>

                            <router-link :to="{name: 'permission_user_profile', params: { id: userprofile.id }}" class="btn btn-info btn-sm">Permission</router-link>


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
    export default {
        components: {
            CardHeader,
        },
        data() {
            return {
                loading:false,
                userprofiles: [],
            }
        },
        created() {
            this.getuserprofiles();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getuserprofiles() {
                this.loading = true;
                this.userprofiles = await this.$root.getAllData('/api/user/userprofiles');
                this.loading = false;
            },
        }
    }
</script>
