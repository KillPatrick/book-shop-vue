import booksIndex from '../components/Books/Index.vue'
import booksShow from '../components/Books/Book.vue'
import booksSearch from '../components/Books/Search.vue'

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
            name: 'books.show'
        }
    ]
}
