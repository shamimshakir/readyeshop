<template>
<div class="card-header d-flex justify-content-between align-items-center font-16 mt-0">
    <strong class="text-primary">{{ title }}</strong>
    <span>
        <button v-if="guideValue.length" class="btn btn-warning btn-sm" @click="changeShowModal(true)">?</button>
        <router-link :to="{name: btnRoute}" class="btn btn-primary btn-sm">{{ btnName }}</router-link>
    </span>
    <help-modal :menu_name="menu_name" />
</div>
</template>

<script>
import HelpModal from '../HelpModal'
export default {
    name: 'CardHeader',
    props: ['title', 'btnRoute', 'btnName', 'menu_name'],
    components: {
        HelpModal,
    },
    data(){
        return {
            guideValue: []
        }
    },
    created() {
        this.getGuideByMenu(this.menu_name);
    },
    methods: {
        changeShowModal(value) {
            this.$store.commit("UPDATE_HELP_MODAL_SHOW", value);
        },
        async getGuideByMenu(value) {
            this.$root.addData({
                'menu_name': value
            }, '/api/user/userguideparam').then(response => {
               this.guideValue = response.data.data;
            }).catch(error => {
                console.dir(error)
            })
        },
    }

}
</script>
