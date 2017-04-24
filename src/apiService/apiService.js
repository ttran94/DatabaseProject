import Vue from 'vue'

const path = 'http://localhost:81/php_controller'
var previousRequest = null
export default {
  authenticate (params) {
    return Vue.http.post(path + '/Conn_DB.php', params)
  },
  register (params) {
    return Vue.http.post(path + '/registration.php', params)
  },
  getDataTypes () {
    return Vue.http.get(path + '/datatypes.php')
  },
  addDataPoint (params) {
    return Vue.http.post(path + '/addpoint.php', params)
  },
  addPOI (params) {
    return Vue.http.post(path + '/addpoi.php', params)
  },
  getState () {
    return Vue.http.get(path + '/state.php')
  },
  getLocations () {
    return Vue.http.get(path + '/locations.php')
  },
  ApprovePending (params) {
    return Vue.http.post(path + '/approve_pending_data.php', params)
  },
  RejectPending (params) {
    return Vue.http.post(path + '/reject_pending_data.php', params)
  },
  getPendingDataPoint () {
    return Vue.http.get(path + '/pending_data.php')
  },
  getPendingOfficial () {
    return Vue.http.get(path + '/pending_official.php')
  },
  getCity () {
    return Vue.http.get(path + '/city.php')
  }
}
