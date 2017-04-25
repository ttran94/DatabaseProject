<template>
  <div class="a-row">
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Username</b></span>
      <input v-validate:username="'required'" v-model="username" type="text" class="form-control" name="username">
      <span v-show="errors.has('username')" class="form-text text-muted help is-danger" style="text-align: left;">{{ errors.first('username') }}</span>
    </div>
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Password</b></span>
      <input v-validate:password="'required'" v-model="password" type="password" class="form-control" name="password">
      <span v-show="errors.has('password')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('password') }}</span>
    </div>
    <div class="text-center">
      <el-button type="primary" :loading="loading" @click="Authenticate" style="width:100%;">Login</el-button>
    </div>
  </div>
</template>
<style>
</style>
<script>
  import API from '@/apiService/apiService'
  export default {
    data () {
      return {
        loading: false,
        username: '',
        password: '',
      }
    },
    methods: {
      Authenticate () {
        var data = {
          username: this.username,
          password: this.password,
        }
        console.log(data)
        this.$validator.validateAll().then((result) => {
          API.authenticate(data).then((response) => {
            console.log(response)
            if (response.body) {
              if (response.body[0].User_type === 'city_scientist') {
                this.$router.push({name: 'ScientistDefault'})
              } else if (response.body[0].User_type === 'administrator') {
                this.$router.push({name: 'AdminDefault'})
              } else if (response.body[0].User_type === 'city_official') {
                this.$router.push({name: 'OfficialDefault'})
              }
            }
          }).catch((error) => {
            console.log(error)
            this.username = ''
            this.password = ''
            this.$message.error(error.body.message);
          })
        })
      }
    }
  }
</script>
