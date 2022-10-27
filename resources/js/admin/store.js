import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
      token: null,
      siteCurrency: "$",
      hostBase: null,
      showHelpModal: false,
    },
    actions: {

    }, 
    mutations: {
        UPDATE_TOKEN_FROM_LOGIN(state, loginToken) {
            state.token = loginToken
        },
        UPDATE_HELP_MODAL_SHOW(state, value) {
            state.showHelpModal = value
        },
        SET_HOST_NAME(state, uri){
            state.hostBase = uri;
        },
    },
})