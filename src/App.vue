<template>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="card vertical-center" style="margin: 0 auto;">
          <div class="card-header" style="background-color: #1F2D3D; color: white;">
            Application Management (Group 88)
          </div>
          <router-view></router-view>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: 'app'
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
