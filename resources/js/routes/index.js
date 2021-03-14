import booksIndex from '../components/Books/Index.vue'
import booksShow from '../components/Books/Book.vue'
import booksSearch from '../components/Books/Search.vue'
import authLogin from '../components/Auth/Login.vue'
import authLogout from '../components/Auth/Logout.vue'
import authRegister from '../components/Auth/Register.vue'

export default {
    mode: 'history',
    routes: [
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
            path: '/login',
            component: authLogin,
            name: 'auth.login',
            beforeEnter: (to, form, next) =>{
                axios.get('/api/v1/athenticated').then(()=>{
                    return next({ name: 'books.index'})
                }).catch(()=>{
                    next()
                })
            }
        },
        {
            path: '/logout',
            component: authLogout,
            name: 'auth.logout'
        },
        {
            path: '/register',
            component: authRegister,
            name: 'auth.register'
        }
    ]
}
