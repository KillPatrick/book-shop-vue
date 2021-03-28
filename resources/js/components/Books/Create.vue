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
    import repository from "../../api/repository";
    import {mapGetters} from "vuex";
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
                    discount: 0,
                },
                genres: [],
                errors: [],
                insertUrl: '',
            }
        },
        computed: {
            ...mapGetters({
                user: 'user'
            })
        },
        methods:{
            saveBook() {
                if(this.user.admin){
                    repository.storeAdminBook(this.book).then(response => {
                        this.$router.push({ name: 'books.index' });
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                    });
                } else {
                    repository.storeBook(this.book).then(response => {
                        this.$router.push({ name: 'books.index' });
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                    });
                }
            }
        }
    }
</script>
