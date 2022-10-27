<template>
<div v-if="showHelpModal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0">{{ guide.question }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" @click="changeShowModal(false)">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div v-html="guide.video"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</div>
</template>

<script>
export default {
    props: ['menu_name'],
    data() {
        return {
            guide: {}
        }
    },
    computed: {
        showHelpModal() {
            return this.$store.state.showHelpModal;
        }
    },
    created() {
        this.getGuideByMenu(this.menu_name);
    },
    watch: {
        menu_name: function (val) {
            this.getGuideByMenu(this.menu_name);
        },
    },
    methods: {
        changeShowModal(value) {
            this.$store.commit("UPDATE_HELP_MODAL_SHOW", value);
        },
        async getGuideByMenu(value) {
            this.$root.addData({
                'menu_name': value
            }, '/api/user/userguideparam').then(response => {
               this.guide = response.data.data[0];
            }).catch(error => {
                console.dir(error)
            })
        },
    }
}
</script>
