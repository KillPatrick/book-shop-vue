import booksIndex from '../components/Books/Index.vue'
import bookIndex from '../components/Books/Book.vue'

export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: booksIndex,
            name: 'books.index'
        },
        {
            path: '/search',
            component: booksIndex,
            name: 'books.search'
        },
        {
            path: '/books/:book_id',
            component: bookIndex,
            name: 'books.show'
        }
    ]
}
