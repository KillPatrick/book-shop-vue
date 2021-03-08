<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <a class="navbar-brand" href="/">Book-shop</a>
            <div class="form-inline">
                <input class="form-control mr-2" v-model="searchString" type="search" placeholder="Title, description, author, genre" name="search">
                <router-link v-if="searchString" :to="{name: 'books.search', params: {searchString: searchString}}" class="form-control btn btn-primary">Search</router-link>
            </div>
            <a class="navbar-brand" href="#">Not approved</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>
<script>
export default{
    data(){
        return {
            searchString: ''
        }
    },
    /*watch: {
        search(after, before){
            this.fetch();
        }
    },
    methods: {
        fetch(){
            this.$router.push({name: 'books.search', params: { search: this.search }});
        }
    }*/
}
</script>
