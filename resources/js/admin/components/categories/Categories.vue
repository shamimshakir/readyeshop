<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Categories" btnRoute="add_category" btnName="Add Category" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <datatable class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }" :columns="columns" :data="categories" :filter="filter" :per-page="25"></datatable>
            <datatable-pager class="datatablePagination" v-model="page"></datatable-pager>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import editButton from "../basics/editButton";
export default {
    components: {
        CardHeader,
        editButton,
    },
    data() {
        return {
            loading: false,
            categories: [],
            filter: "",
            columns: [{
                    label: "#SL",
                    field: "id",
                    align: "center"
                },
                {
                    label: "Category Name",
                    field: "cat_name"
                },
                {
                    label: "Other Language",
                    field: "cat_name_others"
                },
                {
                    label: "Category Code",
                    field: "catagory_code"
                },
                {
                    label: "Level",
                    field: "level_id",
                    align: "center"
                },
                {
                    label: "Parent ID",
                    field: "cat_parent_id",
                    align: "center"
                },
                {
                    field: "id",
                    component: editButton,
                    label: "Action",
                    align: "center",
                    class: "edit_category",
                },
            ],
            page: 1,
        };
    },
    created() {
        this.getCategories();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        onButtonClick() {
            alert("clicked");
        },
        async getCategories() {
            this.loading = true;
            this.categories = await this.$root.getAllData("/api/user/categories");
            this.loading = false;
        },
    },
};
</script>
