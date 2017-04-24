<template>
  <div>
    <div class="authentication">
      <div class="a-row">
        <ul class="nav nav-pills nav-justified">
          <li class="nav-item">
            <router-link class="nav-link" :to="{name: 'Login'}" style="">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{name: 'Register'}" style="">Register</router-link>
          </li>
        </ul>
      </div>
      <div class="card-block">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<style>
  div.authentication a.nav-link {
    border-radius: 0;
  }
  div.authentication a.router-link-active{
    border-bottom: 3px solid #42A5F5;
  }
</style>

<script>
  export default {
    data () {
      return {

      }
    }
  }
</script>
