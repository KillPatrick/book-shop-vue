<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <div v-for="book in books.data" class="col-md-2">
                <books-item :book="book"></books-item>
            </div>
        </div>
        <div class="row justify-content-center">
            <pagination :data="books" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>
<script>
import booksItem from './BookItem.vue'
export default {
    components:{
        booksItem
    },
    data(){
        return {
            books: {},
        }
    },
    mounted() {
        this.getResults();
    },
    methods: {
        getResults(page = 1){
            axios.get('/api/v1/books?page='+page+(this.$route.params.searchString ? '&search='+this.$route.params.searchString : '')).then(response => {
                this.books = response.data;
            });
        }
    }
}
</script>
