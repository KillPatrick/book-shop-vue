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
        doLogout(){
            axios.post('/api/v1/logout').then(() => {
                this.$emit('authCheck', true);
                this.$router.push({name: 'books.index'});
            }).catch(()=>{
                this.$router.push({name: 'books.index'});
            })
        }
    }
}
</script>
