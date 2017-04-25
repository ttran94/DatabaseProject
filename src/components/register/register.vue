<template>
  <div class="a-row">
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Username</b></span>
      <input v-validate:username="'required'" v-model="username" type="text" class="form-control" name="username">
      <span v-show="errors.has('username')" class="form-text text-muted help is-danger" style="text-align: left;">{{ errors.first('username') }}</span>
    </div>
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Email:</b></span>
      <input v-validate:email="'required|email'" v-model="email" type="email" class="form-control" name="email">
      <span v-show="errors.has('email')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('email') }}</span>
    </div>
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Password</b></span>
      <input v-validate:password="'required'" v-model="password" type="password" class="form-control" name="password">
      <span v-show="errors.has('password')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('password') }}</span>
    </div>
    <div class="form-group">
      <span style="font-size: 0.8em; float:left; color: #424242;"><b>Confirm Password</b></span>
      <input v-validate:confirm="'required|confirmed:password'" v-model="confirm" type="password" class="form-control" name="confirm">
      <span v-show="errors.has('confirm')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('confirm') }}</span>
    </div>
    <div class="row reset-col">
      <el-select v-model="userSelected" placeholder="Select User Type">
        <el-option
          v-for="(item, key) in userType"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
      <span v-show="errors.has('userSelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('userSelected') }}</span>
    </div>
    <div class="a-row" v-if="userSelected === 'city_official'">
      <div class="a-row clearfix">
        <p style="font-size:12px; margin-top: 10px; float:left;"> Fill out this form if you choose city official</p>
      </div>
      <div class="row reset-col" style="margin-top:5px; text-align: left;;">
        <div class="col-2 reset-col">
          <span style="vertical-align: middle;">City:</span>
        </div>
        <div class="col-10 reset-col">
          <el-select v-model="citySelected" placeholder="Select City">
            <el-option
              v-for="(item, key) in cities"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
          <span v-show="errors.has('citySelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('citySelected') }}</span>

        </div>
      </div>

      <div class="row reset-col" style="margin-top:10px; text-align: left;">
        <div class="col-2 reset-col">
          <span style="vertical-align: middle;">State:</span>
        </div>
        <div class="col-10 reset-col">
          <el-select v-model="stateSelected" placeholder="Select City">
            <el-option
              v-for="(item, key) in states"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
          <span v-show="errors.has('stateSelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('stateSelected') }}</span>
        </div>
      </div>

      <div class="row reset-col" style="margin-top:10px; text-align: left;">
        <div class="col-2 reset-col">
          <span style="vertical-align: middle;">Title:</span>
        </div>
        <div class="col-10 reset-col">
          <el-input type="text" v-model="title" auto-complete="off" placeholder="Enter Title"></el-input>
          <span v-show="errors.has('title')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('title') }}</span>
        </div>
      </div>
    </div>

    <div class="text-center" style="margin-top:20px;">
      <el-button type="primary" :loading="loading" @click="register" style="width:100%;">Register</el-button>
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
        confirm: '',
        email: '',
        title: '',
        userSelected: null,
        citySelected: null,
        stateSelected: null,
        userType: [
          {
            label: 'City Official',
            value: 'city_official'
          },
          {
            label: 'City Scientist',
            value: 'city_scientist'
          }
        ],
        cities: [
          {
            label: 'Atlanta',
            value: 'Atlanta'
          },
          {
            label: 'City Scientist',
            value: 'city_scientist'
          }
        ],
        states: [
          {
            label: 'City Official',
            value: 'city_official'
          },
          {
            label: 'Georgia',
            value: 'Georgia'
          }
        ]
      }
    },
    methods: {
      resetForm () {
        this.username = ''
        this.email = ''
        this.password = ''
        this.citySelected = ''
        this.stateSelected = ''
        this.userSelected = ''
        this.errors.clear()
      },
      register () {
        var data = {
          username: this.username,
          password: this.password,
          email: this.email,
          userType: this.userSelected,
          city: this.citySelected,
          state: this.stateSelected,
          title: this.title
        }
        this.$validator.attach('userSelected', 'required', {
          prettyName: 'user type',
          context: () => this.userSelected,
          getter: (context) => context
        })

        if (this.userSelected === 'city_official') {
          this.$validator.attach('citySelected', 'required', {
            prettyName: 'city',
            context: () => this.citySelected,
            getter: (context) => context
          })

          this.$validator.attach('stateSelected', 'required', {
            prettyName: 'state',
            context: () => this.stateSelected,
            getter: (context) => context
          })

          this.$validator.attach('title', 'required', {
            prettyName: 'title',
            context: () => this.title,
            getter: (context) => context
          })
        } else {
          this.$validator.detach('stateSelected')
          this.$validator.detach('citySelected')
        }
        this.$validator.validateAll().then((result) => {
          API.register(data).then((response) => {
            console.log(response)
            this.resetForm()
            this.$message({
              message: response.body.message,
              type: 'success'
            })
            this.$router.push({name: 'Login'})
          }).catch((error) => {
            this.resetForm()
            this.$message({
              message: error.body.message,
              type: 'error'
            })
          })
        })
      }
    }
  }
</script>
