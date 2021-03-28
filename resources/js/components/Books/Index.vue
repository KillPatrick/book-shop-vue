<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <div v-for="book in books.data" class="col-md-2">
                <books-item :book="book"></books-item>
            </div>
        </div>
        <div class="row justify-content-center">
            <pagination :data="books" @pagination-change-page="init"></pagination>
        </div>
    </div>
</template>
<script>
    import repository from "../../api/repository";
    import booksItem from './BookItem.vue'
    export default {
        props: ['user'],
        components:{
          booksItem
        },
        data(){
            return {
                books: {},
                page: 1
            }
        },
        created() {
            this.init();
        },
        methods: {
            init(page = 1){
                if(this.user && this.user.admin){
                    repository.getAdminBooks(page).then(response => {
                        this.books = response.data;
                    });
                } else {
                    repository.getBooks(page).then(response => {
                        this.books = response.data;
                    });
                }
            },
        }
    }
</script>
