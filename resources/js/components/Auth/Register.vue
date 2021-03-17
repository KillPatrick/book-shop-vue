<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input v-model="form.name" id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus>
                                    <span v-if="errors.name"    role="alert">
                                        <strong class="text-danger">{{errors.name[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input v-model="form.email" id="email" type="email" class="form-control" name="email" value="" required autocomplete="email">
                                    <span v-if="errors.email"  role="alert">
                                        <strong class="text-danger">{{errors.email[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Date of birth</label>
                                <div class="col-md-6">
                                    <input v-model="form.date_of_birth" id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="" required autocomplete="date of birth">
                                    <span v-if="errors.date_of_birth"  role="alert">
                                        <strong class="text-danger">{{errors.date_of_birth[0]}}</strong>
                                    </span>
                               </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input v-model="form.password"  id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                    <span v-if="errors.password"  role="alert">
                                        <strong class="text-danger">{{errors.password[0]}}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirmation" class="col-md-4 col-form-label text-md-right">Confirm password</label>
                                <div class="col-md-6">
                                    <input v-model="form.password_confirmation"  id="password-confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button @click.prevent="doRegister" type="button" class="btn btn-primary">
                                        Sign up
                                    </button>
                                </div>
                            </div>
                        <hr />
                        <p class="text-center">* Users must be at least 13 years old</p>
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
            form: {
              name: '',
              email: '',
              date_of_birth: '',
              password: '',
              password_confirmation: '',
            },
            errors: []
        }
    },
    methods: {
        doRegister(){
            axios.post('/api/v1/register', this.form).then(response => {
                this.$router.push({name: 'auth.login'});
            }).catch(error => {
                this.errors = error.response.data.errors;
            });
        }
    }
}
</script>
