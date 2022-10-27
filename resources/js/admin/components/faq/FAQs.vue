<template>
<div class="col-lg-12">
    <div class="card m-b-30 mt-5">
        <CardHeader title="FAQs" btnRoute="add_faq" btnName="Add FAQ" :menu_name="routeName" />
        <div class="card-body">
            <vue-loaders-ball-clip-rotate-multiple v-if="loading" scale="1.5" color="#3f51b5" />
            <table class="table table-sm table-bordered mb-0" v-bind:class="{ lessOpacity: loading }">
                <thead>
                    <tr>
                        <th width="8%">#SL</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th class="text-center">Status</th>
                        <th width="8%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="faq in faqs" :key="faq.id">
                        <td>{{ faq.id }}</td>
                        <td>{{ faq.faq_question }}</td>
                        <td>{{ faq.faq_answer }}</td>
                        <td class="text-center">
                            <StatusBadge :status="faq.active_status" />
                        </td>
                        <td class="text-center">
                            <router-link :to="{name: 'edit_faq', params: { id: faq.id }}" class="btn btn-info btn-sm">Edit</router-link>
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
            faqs: [],
        }
    },
    computed: {
        routeName() {
            return this.$route.name;
        }
    },
    created() {
        this.getFaqs();
    },
    methods: {
        async getFaqs() {
            this.loading = true;
            this.faqs = await this.$root.getAllData('/api/user/faqs');
            this.loading = false;
        },
    }
}
</script>

<style>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}
</style>
