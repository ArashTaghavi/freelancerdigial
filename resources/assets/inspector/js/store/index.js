import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        headerText: null,
        notifications: [],
    },
    mutations: {
        headerText(state, text) {
            state.headerText = text;
        },
        notifications(state, value) {
            state.notifications = value;
        },
    }
});
