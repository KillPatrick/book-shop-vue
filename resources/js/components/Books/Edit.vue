<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Edit book</h4>
                        <books-form :book="book" :errors="errors"></books-form>
                        <button @click.prevent="updateBook" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import booksForm from './Form'
    export default {
        components: {
            booksForm
        },
        data(){
            return {
                book: {
                    id: '',
                    title: '',
                    description: '',
                    price: '',
                    authors: '',
                    genres: [],
                    discount: '',
                },
                errors: [],
                updateUrl: '',
                getBookUrl: '',
                user: []
            }
        },
        beforeMount(){
            this.init();
        },
        methods:{
            async init(){
                axios.get('/api/v1/user').then((response) => {
                    this.user = response.data.data;
                    console.log(this.user.admin);
                });
                if (this.user.admin === true) {
                    this.getBookUrl = '/api/v1/admin/books/';
                } else {
                    axios.get('/api/v1/user/owner/' + this.$route.params.book_id).then((response) => {
                        this.getBookUrl = '/api/v1/user/books/';
                    }).catch(() => {
                        this.$router.push({name: 'books.index'});
                    });
                }
                await axios.get(this.getBookUrl+this.$route.params.book_id+'?editing').then(response => {
                    this.book = response.data.data;
                });
            },
            updateBook(){
                if (this.user.admin === true) {
                    this.updateUrl = '/api/v1/admin/books/';
                } else {
                    this.updateUrl = '/api/v1/user/books/';
                }
                axios.put(this.updateUrl+this.book.id, this.book).then((response) => {
                    this.$router.push({name: 'books.index'});
                }).catch(error => {
                    this.errors = error.response.data.errors;
                });

            },
        }
    }
</script>
