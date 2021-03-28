<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Edit book</h4>
                        <books-form :book="book" :errors="errors"></books-form>
                        <button v-if="book" @click.prevent="updateBook" type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from "vuex";
    import booksForm from './Form'
    import repository from "../../api/repository";
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
                errors: []
            }
        },
        computed: {
            ...mapGetters({
                user: 'user'
            })
        },
        created(){
            this.getBook();
            console.log(this.user);
        },
        methods:{
            async getBook(){
                if(this.user && this.user.admin){
                    repository.getAdminBook(this.$route.params.book_id, true).then(response => {
                        this.book = response.data.data;
                    }).catch(errors => {
                        null;
                    });
                } else {
                    repository.getBook(this.$route.params.book_id, true).then(response => {
                        this.book = response.data.data;
                    }).catch(errors => {
                        null;
                    });
                }
            },
            updateBook(){
                if (this.user && this.user.admin) {
                    repository.updateAdminBook(this.book).then((response) => {
                        this.$router.push({name: 'books.index'});
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                    });
                } else {
                    repository.updateBook(this.book).then((response) => {
                        this.$router.push({name: 'books.index'});
                    }).catch(error => {
                        this.errors = error.response.data.errors;
                    });
                }
            },
        }
    }
</script>
