<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <books-item :book="book"></books-item>
                <div v-if="user" class="btn-toolbar mt-1">
                    <div class="btn-group mr-1">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">Write a review</button>
                    </div>
                    <div v-if="editBook" class="btn-group mr-1">
                        <router-link :to="{ name: 'books.edit', params: {book_id: book.id} }" class="btn btn-primary" >Edit book</router-link>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-2">Description</h5>
                <div class="card shadow-sm bg-white rounded-lg">
                    <div class="card-body p-0">
                        <p class="card-text p-2">
                            {{ book.description }}
                        </p>
                    </div>
                </div>
                <h5 class="mt-4 mb-2">Users reviews</h5>
                <div v-for="review in reviews" class="card shadow-sm bg-white rounded-lg mb-3">
                    <div class="card-body p-0">
                        <div class="card-header">
                            <h5>{{ review.title }}</h5>
                            <hr />
                            <p>
                                <span v-for="i in 10" :class="{'text-warning rating-star' : i <= review.rating,
                                                                'rating-star' : i > review.rating}">
                                    &#9733;
                                </span>
                            </p>
                        </div>
                        <p class="card-text p-2">
                            {{ review.review }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="user" class="modal" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Write a review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <select v-model="userReview.rating" name="rating" class="form-control" id="rating" required>
                                <option v-for="n in 10" :value="n" :selected="selected === n">
                                    {{n}} - <span v-for="j in n">&#9733</span>
                                </option>
                            </select>
                            <span v-if="errors.rating"  role="alert">
                                <strong class="text-danger">{{errors.rating[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input v-model="userReview.title" type="text" name="title" class="form-control" id="title" required>
                            <span v-if="errors.title"  role="alert">
                                <strong class="text-danger">{{errors.title[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea v-model="userReview.review" class="form-control" name="review" id="review" rows="5" required>{{userReview.review}}</textarea>
                            <span v-if="errors.review"  role="alert">
                                <strong class="text-danger">{{errors.review[0]}}</strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button @click.prevent="saveReview" type="button" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import booksItem from './BookItem'
    import repository from "../../api/repository";
    export default {
        components:{
            booksItem
        },
        data(){
            return {
                selected: '10',
                book: [],
                reviews: [],
                userReview: {
                    id: '',
                    rating: '',
                    title: '',
                    review: '',
                    book_id: '',
                },
                editBook: false,
                errors: []
            }
        },
        computed: {
            ...mapGetters({
                user: 'user'
            })
        },
        created() {
            this.init();
        },
        methods:{
            async init(){
                this.errors = [];
                await this.getUserReview();
                await this.getBook();
                await this.getReviews();
            },
            getUserReview(){
                if(this.user){
                    repository.getUserReview(this.$route.params.book_id).then(response => {
                        this.userReview = response.data.data;
                    }).catch(errors => {
                        null;
                    });
                }
            },
            getBook(){
                if(this.user && this.user.admin){
                    repository.getAdminBook(this.$route.params.book_id).then(response => {
                       this.book = response.data.data;
                       this.editBook = true;
                       this.userReview.book_id = this.book.id;
                    }).catch(errors => {
                        null;
                    });
                } else {
                    repository.getBook(this.$route.params.book_id).then(response => {
                        this.book = response.data.data;
                        if(this.user && this.book.user_id === this.user.id){
                            this.editBook = true;
                        }
                        this.userReview.book_id = this.book.id;
                    }).catch(errors => {
                        null;
                    });
                }
            },
            getReviews(){
                repository.getReviews(this.$route.params.book_id).then(response => {
                    this.reviews = response.data.data;
                }).catch(errors => {
                    null;
                });
            },
            async saveReview(){
                //todo errors handle
                if(this.userReview.id){
                   await repository.updateReview(this.userReview).then(response => {
                       this.init();
                       $('#modal').modal('hide');
                   }).catch(error => {
                       this.errors = error.response.data.errors;
                   });
                } else {
                   await repository.storeReview(this.userReview).then(response => {
                       this.init();
                       $('#modal').modal('hide');
                   }).catch(error => {
                       this.errors = error.response.data.errors;
                   });
                }
            }
        }
    }
</script>
