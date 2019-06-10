/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';


Vue.use(Vuex);

const vuexLocalStorage = new VuexPersist({
    key: 'vuex', // The key to store the state on in the storage provider.
    storage: window.localStorage, // or window.sessionStorage or localForage
    // Function that passes the state and returns the state with only the objects you want to store.
    // reducer: state => state,
    // Function that passes a mutation and lets you decide if it should update the state in localStorage.
    // filter: mutation => (true)
  })

const store = new Vuex.Store({
    state: {
        token: "",
        user: null
    },
    mutations: {
        clearUserAndToken: (state) => {
            state.user = null;
            state.token = "";
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        clearUser: (state) => {
            state.user = null;
            localStorage.removeItem('user');
        },
        clearToken: (state) => {
            state.token = "";
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        setUser: (state, user) => {
            state.user = user;
            localStorage.setItem('user', JSON.stringify(user));
        },
        setToken: (state, token) => {
            state.token = token;
            localStorage.setItem('token', token);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
        },
        loadTokenAndUserFromSession: (state) => {
            state.token = "";
            state.user = null;
            let token = localStorage.getItem('token');
            let user = localStorage.getItem('user');
            if (token) {
                state.token = token;
                axios.defaults.headers.common.Authorization = "Bearer " + token;
            }
            if (user) {
                state.user = JSON.parse(user);
            }
        },
        getUser: (state) => {
            axios.get('/api/get-user').then(response => {
                state.user = response.data.data;
            }).catch(response => {
                if (response.status === 401) {
                    this.logout();
                }
            })
        },

        check(state) {
            return !!state.token;
        }
    },
    plugins: [vuexLocalStorage.plugin]

});

export default store;
