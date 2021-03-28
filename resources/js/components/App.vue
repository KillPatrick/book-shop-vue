<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <a class="navbar-brand" href="/">Book-shop</a>
            <div class="form-inline">
                <input class="form-control mr-2" v-model="searchString" type="search" placeholder="Title, description, author, genre" name="search">
                <router-link v-if="searchString" :to="{name: 'books.search', params: {searchString: searchString}}" class="form-control btn btn-primary">Search</router-link>
            </div>
            <router-link v-if="!user" :to="{ name: 'auth.login' }" class="navbar-brand" >Login</router-link>
            <router-link v-if="!user" :to="{ name: 'auth.register' }" class="navbar-brand" >Register</router-link>
            <router-link v-if="user" :to="{ name: 'books.create' }" class="navbar-brand" >Add a book</router-link>
            <router-link v-if="user" :to="{ name: 'auth.logout' }" class="navbar-brand" >Logout</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
        <main class="py-4">
            <router-view :user="user"></router-view>
        </main>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
export default{
    data(){
        return {
            auth: '',
            searchString: ''
        }
    },
    computed: {
        ...mapGetters({
            user: 'user'
        })
    }
}
</script>
