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
                        </div>
                        <div class="form-group">
                            <label for="authors">Authors*</label>
                            <input v-model="book.authors" type="text" name="authors" class="form-control" id="authors" required>
                            <small>*Separate authors by comma</small>
                        </div>
                        <div class="form-group">
                            <label for="genres">Genres*</label>
                            <select multiple name="genres[]" class="form-control" id="genres" required>
                                <option v-for="genre in book.genres" :value="genre.id">{{genre.name}}</option>
                            </select>
                            <small>*Multiple genres can be selected by hold ctrl/cmd key</small>
                        </div>
                        <div class="form-group">
                            <label for="description">Example textarea</label>
                            <textarea v-model="book.description" class="form-control" name="description" id="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price &euro;</label>
                            <input v-model="book.price" class="form-control" name="price" id="price" rows="5" type="number" min="0.1" step="0.01" value=""  required />
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount %</label>
                            <input v-model="book.discount" class="form-control" name="discount" id="discount" rows="5" type="number" min="0" max="100" value=""  required />
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
                }
            }
        },
        created(){
            this.getGenres();
        },
        methods:{
            getGenres(){
                axios.get('api/v1/genres').then(response => {
                    this.book.genres = response.data.data;
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
                            });
                        }
                    });
                });
            }
        }
    }
</script>
