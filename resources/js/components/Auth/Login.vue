<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                            <div class="col-md-6">
                                <input v-model="form.email" id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                                <span v-if="errors.email">
                                    <strong class="text-danger">{{errors.email[0]}}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input v-model="form.password" id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                                <span v-if="errors.password">
                                    <strong class="text-danger">{{errors.password[0]}}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button @click.prevent="doLogin" type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form:{
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods: {
        async doLogin(){
            this.error = null;
            try {
                await this.$store.dispatch('login', this.form);
                await this.$router.push({ name: 'books.index' });
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
            /*axios.post('/api/v1/login', this.form).then(response => {
                this.$emit('authCheck', true)
                this.$router.push({name: 'books.index'});
            }).catch(error => {
                this.errors = error.response.data.errors;
            });*/
        }
    }
}
</script>
