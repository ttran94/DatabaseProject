// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import VueRouter from 'vue-router'
import Resource from 'vue-resource'
import routes from './router/index'
import VeeValidate from 'vee-validate'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
locale.use(lang)
Vue.use(ElementUI)
Vue.use(VueRouter)
Vue.use(Resource)
Vue.use(VeeValidate)

Vue.config.productionTip = false

var router = new VueRouter({
  routes: routes,
  mode: 'history'
})

router.beforeEach((to, from, next) => {
  next()
})

Vue.http.interceptors.push(function(request, next) {
    request.headers.set('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    next()
})
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router: router,
  template: '<App/>',
  components: { App }
})
