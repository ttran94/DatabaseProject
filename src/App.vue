<template>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="card vertical-center" style="margin: 0 auto;">
          <div class="card-header" style="background-color: #1F2D3D; color: white;">
            Application Management (Group 88)
          </div>
          <nav class="navbar navbar-inverse" style="background-color: #1E88E5;" v-if="isRoute">
           <div class="a-row" style="color: white;">
             <i class="fa fa-backward float-left" aria-hidden="true" style="color: white;" @click="goBack" v-if="isParent"><b style="cursor: pointer; margin-left: 10px;">Back</b></i>
             <i class="fa fa-sign-out float-right" aria-hidden="true" style="color: white;" @click="signOut"><b style="cursor: pointer; margin-left: 10px;">Sign Out</b></i>
           </div>

          </nav>
          <router-view></router-view>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'app',
  data () {
    return {

    }
  },
  methods: {
    goBack () {
      this.$router.push({name: this.$route.meta.parent})
    },
    signOut () {
      this.$router.push({name: 'Login'})
    }
  },
  mounted () {
    console.log(this.$route)
  },
  computed: {
    isRoute () {
      if (this.$route.name !== 'Login' && this.$route.name !== 'Register') {
        return true
      } else {
        return false
      }
    },
    isParent () {
      if (this.$route.meta.parent !== undefined && this.$route.meta.parent !== null) {
        return true
      } else {
        return false
      }
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

.reset-col {
  margin: 0;
  padding: 0;
}
.el-select {
  width: 100%;
}

.el-date-editor.el-input {
  width: 100% !important;
}

.help.is-danger {
    color: #ff3860 !important;
}
.help {
    display: block;
    font-size: 11px;
    margin-top: 5px;
}

button {
  cursor: pointer;
}
.a-row {
  width: 100%;
}
</style>
