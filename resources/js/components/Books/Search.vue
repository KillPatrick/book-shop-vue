<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <div v-if="books.data" v-for="book in books.data" class="col-md-2">
                <books-item :book="book"></books-item>
            </div>
        </div>
        <div v-if="books.data" class="row justify-content-center">
            <pagination :data="books" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>
<script>
import booksItem from './BookItem.vue'
import {mapGetters} from 'vuex'
import repository from "../../api/repository";
export default {
    components:{
        booksItem
    },
    data(){
        return {
            books: {},
        }
    },
    computed:{
        ...mapGetters({
            user: 'user'
        })
    },
    created() {
        this.getResults();
    },
    methods: {
        getResults(page = 1){
            if(this.user && this.user.admin){
                repository.getAdminSearchResults(page, this.$route.params.searchString).then(response => {
                    this.books = response.data;
                });
            } else {
                repository.getSearchResults(page, this.$route.params.searchString).then(response => {
                    this.books = response.data;
                });
            }
        }
    }
}
</script>
