<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <books-item :book="book"></books-item>
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
            book: [],
            reviews: [],
            userReview: '',
        }
    },
    created() {
        axios.get('/sanctum/csrf-cookie').then(response => {
            this.getUserReview();
        });
        this.getBook();
        this.getReviews();
    },
    methods:{
        getBook(){
            axios.get('/api/v1/books/'+this.$route.params.book_id).then(response => {
                this.book = response.data.data;
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
                console.log(this.userReview);
            });
        }
    }
}
</script>
