<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <a class="navbar-brand" href="/">Book-shop</a>
            <div class="form-inline">
                <input class="form-control mr-2" v-model="searchString" type="search" placeholder="Title, description, author, genre" name="search">
                <router-link v-if="searchString" :to="{name: 'books.search', params: {searchString: searchString}}" class="form-control btn btn-primary">Search</router-link>
            </div>
            <router-link v-if="auth === 'logged out'" :to="{ name: 'auth.login' }" class="navbar-brand" >Login</router-link>
            <router-link v-if="auth === 'logged in'" :to="{ name: 'auth.logout' }" class="navbar-brand" >Logout</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
        <main class="py-4">
            <router-view @authCheck="checkAuth"></router-view>
        </main>
    </div>
</template>
<script>
export default{
    data(){
        return {
            auth: '',
            searchString: ''
        }
    },
    created(){
        this.checkAuth();
    },
    methods: {
        checkAuth(){
            axios.get('/api/v1/athenticated').then(()=>{
                this.auth = 'logged in';
            }).catch(()=>{
                this.auth = 'logged out';
            })
        }
    }
}
</script>
