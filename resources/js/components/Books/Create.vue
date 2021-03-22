<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Create book</h4>
                        <books-form :book="book" :errors="errors"></books-form>
                        <button @click.prevent="saveBook" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import booksForm from './Form'
    export default {
        components:{
            booksForm
        },
        data(){
            return {
                book: {
                    title: '',
                    description: '',
                    price: '',
                    authors: '',
                    genres: [],
                    discount: '',
                },
                genres: [],
                errors: [],
            }
        },
        methods:{
            saveBook(){
                axios.get('/api/v1/athenticated').then(()=> {
                    axios.get('/api/v1/user').then((response) => {
                        this.user = response.data.data;
                        if (this.user.admin) {
                            axios.post('/api/v1/admin/books', this.book).then((response) => {
                                null;
                            }).catch(error => {
                                this.errors = error.response.data.errors;
                            });
                        }
                    });
                });
            }
        }
    }
</script>
