<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                Logging out...
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created(){
        this.doLogout();
    },
    methods: {
        async doLogout(){
            await this.$store.dispatch('logout');
            await this.$router.push({ name: 'books.index' });
        }
    }
}
</script>
