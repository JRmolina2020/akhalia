import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        users: [],
        status: false,
        urluser: "users"
    },
    mutations: {
        ListUserM(state, item) {
            state.users = item;
        }
    },
    actions: {
        async ListUserA({ commit, state }) {
            try {
                let response = await axios.get(state.urluser);
                commit("ListUserM", response.data);
                state.status = true;
            } catch (error) {
                console.log(error);
            }
        }
    }
});
