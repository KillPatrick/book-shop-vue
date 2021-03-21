<template>
    <div class="container-fluid">
        <div class="row mb-3">
            <div v-for="book in books" class="col-md-2">
                <books-item :book="book"></books-item>
            </div>
        </div>
        <div class="row justify-content-center">
            <pagination :data="books" @pagination-change-page="init"></pagination>
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
                user: {},
                page: 1
            }
        },
        created() {
            this.init();
        },
        methods: {
            init(page = 1){
                axios.get('/api/v1/athenticated').then(()=> {
                    axios.get('/api/v1/user').then((response) => {
                        this.user = response.data.data;
                        if (this.user.admin) {
                            this.getAdminResults(page);
                            return;
                        }
                    });
                });
                this.getResults(page);
            },
            getResults(page = 1){
                axios.get('/api/v1/books?page='+page).then(response => {
                    this.books = response.data;
                });
            },
            getAdminResults(page = 1){
                axios.get('/api/v1/admin/books?page='+page).then(response => {
                    this.books = response.data.data;
                });
            }
        }
    }
</script>
