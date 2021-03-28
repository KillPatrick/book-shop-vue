
import Vue from 'vue'
import VueRouter from 'vue-router'
import booksIndex from '../components/Books/Index.vue'
import booksShow from '../components/Books/Book.vue'
import booksSearch from '../components/Books/Search.vue'
import booksCreate from '../components/Books/Create.vue'
import booksEdit from '../components/Books/Edit.vue'
import authLogin from '../components/Auth/Login.vue'
import authLogout from '../components/Auth/Logout.vue'
import authRegister from '../components/Auth/Register.vue'
import notFound from '../components/Errors/NotFound.vue'

import middleware from './middleware'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            component: notFound,
            name: 'not_found'
        },
        {
            path: '/',
            component: booksIndex,
            name: 'books.index'
        },
        {
            path: '/search/:searchString',
            component: booksSearch,
            name: 'books.search'
        },
        {
            path: '/books/:book_id',
            component: booksShow,
            name: 'books.show',
        },
        {
            path: '/create',
            component: booksCreate,
            name: 'books.create',
            beforeEnter: middleware.user
        },
        {
            path: '/edit/:book_id',
            component: booksEdit,
            name: 'books.edit',
            beforeEnter: middleware.user
        },
        {
            path: '/login',
            component: authLogin,
            name: 'auth.login',
            beforeEnter: middleware.guest
        },
        {
            path: '/logout',
            component: authLogout,
            name: 'auth.logout',
            beforeEnter: middleware.user
        },
        {
            path: '/register',
            component: authRegister,
            name: 'auth.register',
            beforeEnter: middleware.guest
        }
    ],
});

export default router

