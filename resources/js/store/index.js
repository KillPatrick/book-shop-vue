import Vue from 'vue'
import Vuex from 'vuex'
import repository from "../api/repository";

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        user: localStorage.user ? JSON.parse(localStorage.getItem('user')) : null
    },
    getters: {
        user: state => state.user,
    },
    mutations: {
        SET_USER: (state, data) => state.user = data,
    },
    actions: {
        async login({ commit }, user) {
            const { data } = await repository.login(user);
            commit('SET_USER', data.data);
            localStorage.setItem('user', JSON.stringify(data.data));
        },
        async logout({ commit }) {
            await repository.logout();
            commit('SET_USER', null);
            localStorage.removeItem('user');
        }
    }
});

export default store
