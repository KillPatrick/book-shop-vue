import api from "./api";

export default {
  createSession() {
      return api.get('/sanctum/csrf-cookie');
  },

  login(params) {
      return api.post('/api/v1/login', params);
  },

  logout() {
      return api.post('/api/v1/logout');
  },

  user() {
      return api.get('/api/v1/user');
  },

  getPosts() {
      return api.get(`http://localhost/api/posts`);
  },

  getBooks(page = 1){
      return api.get('/api/v1/books?page='+page);
  },

  getAdminBooks(page = 1){
      return api.get('/api/v1/admin/books?page='+page);
  },

  storeBook(book){
      return api.post('/api/v1/user/books', book);
  },

  storeAdminBook(book){
      return api.post('/api/v1/admin/books', book);
  },

  getUserReview(bookId) {
      return api.get('/api/v1/user_review?book_id='+bookId);
  },

  getBook(bookId){
      return api.get('/api/v1/books/'+bookId);
  },

  getAdminBook(bookId){
      return api.get('/api/v1/admin/books/'+bookId);
  },

  getReviews(bookId){
      return api.get('/api/v1/reviews?book_id='+bookId);
  },

  storeReview(review){
      return api.post('/api/v1/review/store', review);
  },

  updateReview(review){
     return api.post('/api/v1/review/update/'+review.id, review);
  },

  getSearchResults(page = 1, searchString = ''){
      return api.get('/api/v1/books?page='+page+(searchString ? '&search='+searchString : ''));
  },

  getAdminSearchResults(page = 1, searchString = ''){
      return api.get('/api/v1/admin/books?page='+page+(searchString ? '&search='+searchString : ''));
  }
};
