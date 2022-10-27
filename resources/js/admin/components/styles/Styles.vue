<template>
    <div class="col-lg-12">
        <div class="card m-b-30 mt-5">
            <CardHeader
                title="CSS Colors"
                btnRoute="add_style"
                btnName="Add Style"
                :menu_name="routeName"
            />
            <div class="card-body">
                <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
                <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                    <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Label</th>
                        <th>Item/Selector</th>
                        <th>Color</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="style in styles" :key="style.id">
                        <td>{{ style.id }}</td>
                        <td>{{ style.label }}</td>
                        <td>{{ style.item }}</td>
                        <td><div class="shadow-sm rounded colorBox" :style="'background-color: '+style.item_value "></div></td>
                        <td class="text-center">
                            <StatusBadge :status="style.status"/>
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_style', params: { id: style.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
                styles: [],
            }
        },
        created() {
            this.getStyles();
        },
        computed: {
            routeName() {
                return this.$route.name;
            }
        },
        methods: {
            async getStyles() {
                this.loading = true;
                this.styles = await this.$root.getAllData('/api/user/csses');
                this.loading = false;
            },
        }
    }
</script>

<style scoped>
.colorBox{
    height: 20px;
}
</style>