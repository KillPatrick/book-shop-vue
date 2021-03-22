<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <books-item :book="book"></books-item>
                <div v-if="auth" class="btn-toolbar mt-1">
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
        <div v-if="auth" class="modal" id="modal" tabindex="-1" role="dialog">
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
                                <option v-for="n in 10" :value="n" :selected="selected == n">
                                    {{n}} - <span v-for="j in n">&#9733</span>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input v-model="userReview.title" type="text" name="title" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea v-model="userReview.review" class="form-control" name="review" id="review" rows="5" required>{{userReview.review}}</textarea>
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
    import booksItem from './BookItem'
    export default {
        components:{
            booksItem
        },
        data(){
            return {
                auth: false,
                selected: '10',
                book: [],
                reviews: [],
                userReview: {
                    rating: '',
                    title: '',
                    review: '',
                    book_id: '',
                },
                editBook: false
            }
        },
        created() {
            axios.get('/api/v1/athenticated').then(()=>{
                this.getUserReview();
                this.auth = true;
            }).catch(()=>{
                null;
            })
            this.init();
            this.getReviews();
        },
        methods:{
            init(){
                axios.get('/api/v1/athenticated').then(()=>{
                    axios.get('/api/v1/user').then((response)=>{
                        this.user = response.data.data;
                        if(this.user.admin){
                            this.getAdminBook();
                            this.editBook = true;
                            return;
                        } else {
                            this.getBook();
                            axios.get('/api/v1/user/owner/'+this.book.id).then((response)=>{
                                this.editBook = true;
                            });
                            return;
                        }
                    });
                });
                this.getBook();
            },
            getBook(){
                axios.get('/api/v1/books/'+this.$route.params.book_id).then(response => {
                    this.book = response.data.data;
                    if(!this.userReview.book_id){
                        this.userReview.book_id = this.book.id;
                    }
                });
            },
            getAdminBook(){
                axios.get('/api/v1/admin/books/'+this.$route.params.book_id).then(response => {
                    this.book = response.data.data;
                    if(!this.userReview.book_id){
                        this.userReview.book_id = this.book.id;
                    }
                });
            },
            getReviews(){
                axios.get('/api/v1/reviews?book_id='+this.$route.params.book_id).then(response => {
                    this.reviews = response.data.data;
                });
            },
            getUserReview(){
                axios.get('/api/v1/user_review?book_id='+this.$route.params.book_id).then(response => {
                    this.userReview = response.data.data;
                    this.selected = this.userReview.rating;
                }).catch(()=>{
                    null;
                });
            },
            saveReview(){
                if(this.userReview.id){
                    axios.post('/api/v1/review/update/'+this.userReview.id, this.userReview).then(response => {
                        this.getBook();
                        this.getReviews();
                        $('#modal').modal('hide');
                    }).catch(() => {
                        null;
                    });
                } else {
                    axios.post('/api/v1/review/store', this.userReview).then(response => {
                        this.getBook();
                        this.getReviews();
                        $('#modal').modal('hide');
                    }).catch(() => {
                        null;
                    });
                }
            }
        }
    }
</script>
