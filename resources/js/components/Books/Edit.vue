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
            }
        },
        created(){
            this.getBook();
        },
        methods:{
            updateBook(){
                axios.get('/api/v1/athenticated').then(()=> {
                    axios.get('/api/v1/user').then((response) => {
                        this.user = response.data.data;
                        if (this.user.admin) {
                            axios.put('/api/v1/admin/books/'+this.book.id, this.book).then((response) => {
                                null;
                            }).catch(error => {
                                this.errors = error.response.data.errors;
                            });
                        }
                    });
                });
            },
            getBook(){
                axios.get('/api/v1/books/'+this.$route.params.book_id+'?editing').then(response => {
                    this.book = response.data.data;
                });
            },
        }
    }
</script>
