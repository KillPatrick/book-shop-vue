require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import App from './components/App.vue'

Vue.use(Vuex)

import store from './store'

Vue.component('pagination', require('laravel-vue-pagination'))

import router from './router'

/*router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record  => record.meta.requiresAuth)
    const requiresGuest = to.matched.some(record  => record.meta.requiresGuest)
    let user = {}

    if (requiresAuth) {
        if(user){
            return next()
        } else {
            return next({ name: 'books.index'})
        }
    } else {
        next()
    }

    if (requiresGuest) {
        axios.get('/api/v1/athenticated').then(()=>{
            return next({ name: 'books.index'})
        }).catch(()=>{
            next()
        })
    } else {
        next()
    }
});*/

const app = new Vue({
    el : '#app',
    store: store,
    components: { App },
    router: router
});
