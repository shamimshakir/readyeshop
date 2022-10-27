<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="Products" btnRoute="add_product" btnName="Add Product" :menu_name="routeName" />
        <div class="card-body">
            <div class="filterCustomer">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <p class="mb-0">Search Product</p>
                            <input type="text" class="form-control border border-secondary" v-model="filter" placeholder="Search" @keydown="$event.stopImmediatePropagation()" />
                        </div>
                    </div>
                </div>
            </div>
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <datatable v-bind:class="{ lessOpacity: loading }" class="table table-sm table-bordered mb-0" :columns="columns" :data="products" :filter="filter" :per-page="25"></datatable>
            <datatable-pager class="datatablePagination" v-model="page"></datatable-pager>
        </div>
    </div>
</div>
</template>

<script>
import CardHeader from "../basics/CardHeader";
import StatusBadge from "../basics/StatusBadge";
import editButton from "../basics/editButton";
export default {
    components: {
        CardHeader,
        StatusBadge,
        editButton
    },
    data() {
        return {
            loading: false,
            products: [],
            product_image_url: "",
            filter: "",
            columns: [{
                    label: "#SL",
                    field: "id",
                    align: 'center',
                },
                {
                    label: "Product Name",
                    field: "pd_name"
                },
                {
                    label: "Category",
                    field: "category.cat_name"
                },
                {
                    label: "Brand",
                    field: "brand.brand_display"
                },
                {
                    label: "Price",
                    field: "pd_price"
                },
                {
                    label: "Quantity",
                    field: "pd_qty",
                    align: 'center',
                },
                {
                    label: "Status",
                    align: 'center',
                    representedAs: ({
                        pd_thumbnail
                    }) => {
                        if (pd_thumbnail) {
                            return `<img class="img-thumbnail table_product_thumbnail" src="${this.product_image_url}${pd_thumbnail}" />`;
                        }
                    },
                    interpolate: true,
                },
                {
                    label: "Status",
                    align: 'center',
                    representedAs: ({
                        pd_status
                    }) => {
                        if (pd_status == 1) {
                            return `<span class="badge badge-success">Active</span>`;
                        } else {
                            return `<span class="badge badge-danger">Inactive</span>`;
                        }
                    },
                    interpolate: true,
                },
                {
                    field: "id",
                    component: editButton,
                    label: "Action",
                    align: 'center',
                    class: "edit_product"
                },
            ],
            page: 1,
        };
    },
    created() {
        this.getProducts();
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    methods: {
        async getProducts() {
            this.loading = true;
            let data = await this.$root.getAllDataWithImages('/api/user/products');
            this.product_image_url = data[0].url;
            this.products = data[0].data;
            this.loading = false;
        },
    },
};
</script>
