<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Add your book</h4>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input v-model="book.title" type="text" name="title" class="form-control" id="title" required>
                            <span v-if="errors.title"  role="alert">
                                <strong class="text-danger">{{errors.title[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="authors">Authors*</label>
                            <input v-model="book.authors" type="text" name="authors" class="form-control" id="authors" required>
                            <strong>*Separate authors by comma</strong>
                            <span v-if="errors.authors"  role="alert">
                                <br />
                                <strong class="text-danger">{{errors.authors[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="genres">Genres*</label>
                            <select v-model="book.genres" multiple name="genres[]" class="form-control" id="genres" required>
                                <option v-for="genre in genres" :value="genre.id">{{genre.name}}</option>
                            </select>
                            <strong>*Multiple genres can be selected by hold ctrl/cmd key</strong>
                            <span v-if="errors.genres"  role="alert">
                                <br />
                                <strong class="text-danger">{{errors.genres[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="description">Example textarea</label>
                            <textarea v-model="book.description" class="form-control" name="description" id="description" rows="5" required></textarea>
                            <span v-if="errors.description"  role="alert">
                                <strong class="text-danger">{{errors.description[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="price">Price &euro;</label>
                            <input v-model="book.price" class="form-control" name="price" id="price" rows="5" type="number" min="0.1" step="0.01" value=""  required />
                            <span v-if="errors.price"  role="alert">
                                <strong class="text-danger">{{errors.price[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount %</label>
                            <input v-model="book.discount" class="form-control" name="discount" id="discount" rows="5" type="number" min="0" max="100" value=""  required />
                            <span v-if="errors.discount"  role="alert">
                                <strong class="text-danger">{{errors.discount[0]}}</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="customFile">Cover image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="image">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <button @click.prevent="saveBook" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
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
        created(){
            this.getGenres();
        },
        methods:{
            getGenres(){
                axios.get('api/v1/genres').then(response => {
                    this.genres = response.data.data;
                    console.log(this.genres);
                });
            },
            saveBook(){
                axios.get('/api/v1/athenticated').then(()=> {
                    axios.get('/api/v1/user').then((response) => {
                        this.user = response.data.data;
                        if (this.user.admin) {
                            axios.post('/api/v1/admin/books', this.book).then((response) => {
                                console.log('done');
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
