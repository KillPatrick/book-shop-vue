import booksIndex from '../components/Books/Index.vue'
import booksShow from '../components/Books/Book.vue'
import booksSearch from '../components/Books/Search.vue'
import booksEdit from '../components/Books/Edit.vue'
import authLogin from '../components/Auth/Login.vue'
import authLogout from '../components/Auth/Logout.vue'
import authRegister from '../components/Auth/Register.vue'
import notFound from '../components/Errors/NotFound.vue'



export default {
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
            component: booksEdit,
            name: 'books.create',
            beforeEnter: (to, form, next) =>{
                axios.get('/api/v1/athenticated').then(()=>{
                    next()
                }).catch(()=>{
                    return next({ name: 'books.index'})
                })
            }
        },
        {
            path: '/edit/:book_id',
            component: booksEdit,
            name: 'books.edit',
            beforeEnter: (to, form, next) =>{
                axios.get('/api/v1/athenticated').then(()=>{
                    return next({ name: 'books.index'})
                }).catch(()=>{
                    next()
                })
            }
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
            name: 'auth.register',
            beforeEnter: (to, form, next) =>{
                axios.get('/api/v1/athenticated').then(()=>{
                    return next({ name: 'books.index'})
                }).catch(()=>{
                    next()
                })
            }
        }
    ]
}
