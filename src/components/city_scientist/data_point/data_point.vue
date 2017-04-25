<template>
  <div style="text-align: left !important;vertical-align: middle;">
    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">POI Location Name</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedLocation" placeholder="Select">
          <el-option
            v-for="(item, key) in locations"
            :label="item.Location_name"
            :value="item.Location_name">
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">Time and Date</span>
      </div>
      <div class="col-6 reset-col">
        <el-date-picker
          v-model="selectedDatetime"
          type="datetime"
          format="yyyy/MM/dd HH:mm"
          placeholder="Select date and time">
        </el-date-picker>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">Data Type</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedType" placeholder="Select">
          <el-option
            v-for="(item, key) in dataTypes"
            :label="item.Type"
            :value="item.Type">
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">Data Value</span>
      </div>
      <div class="col-6 reset-col">
        <el-input placeholder="Data Value" v-model="value"></el-input>
      </div>
    </div>

    <div class="row reset-col text-center" style="margin-top:20px; margin-bottom: 20px;">
      <button class="btn btn-primary btn-sm text-center" style="margin: 0 auto;" @click="submit">Submit</button>
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
        selectedDatetime: null,
        selectedLocation: null,
        selectedType: null,
        value: null,
        locations: [],
        dataTypes: []
      }
    },
    methods: {
      resetForm () {
        this.selectedDatetime =  null
        this.selectedLocation = null
        this.selectedType = null
        this.value = null
      },
      submit () {
        var params = {
          location: this.selectedLocation,
          date: this.selectedDatetime,
          value: this.value,
          type: this.selectedType
        }
        console.log(params)
        API.addDataPoint(params).then((response) => {
          console.log(response)
          this.$message({
            message: response.body.message,
            type: 'success'
          })
          this.resetForm()
        }).catch((error) => {
          console.log(error)
          this.$message({
            message: error.body ? error.body.message : error.bodyText,
            type: 'error'
          })
        })
      }
    },
    mounted () {
      API.getLocations().then((response) => {
        this.locations = response.body
      })
      API.getDataTypes().then((response) => {
        this.dataTypes = response.body
      })

    }
  }
</script>
