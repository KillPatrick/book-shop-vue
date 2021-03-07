<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Book-shop</a>
                <form class="form-inline my-2 my-lg-0" method="GET" action="/">
                    <input class="form-control mr-sm-2" v-model.lazy="search" type="search" placeholder="Title, description, author, genre" name="search">
                </form>
                <a class="navbar-brand" href="#">Not approved</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
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
            search: null
        }
    },
    watch: {
        search(after, before){
            this.fetch();
        }
    },
    methods: {
        fetch(){
            this.$router.push({name: 'books.search', params: { search: this.search }});
        }
    }
}
</script>
