<template>
  <div style="text-align: left !important;vertical-align: middle;">
    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">POI Location Name</span>
      </div>
      <div class="col-6 reset-col">
        <el-input placeholder="Location Name" v-model="location"></el-input>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">City</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedCity" placeholder="Select">
          <el-option
            v-for="(item, key) in city"
            :label="item.City"
            :value="item.City">
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">State</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedState" placeholder="Select">
          <el-option
            v-for="(item, key) in state"
            :label="item.State"
            :value="item.State">
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">Zip code:</span>
      </div>
      <div class="col-6 reset-col">
        <el-input placeholder="Zip Code" v-model="zipcode"></el-input>
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
        selectedCity: null,
        selectedLocation: null,
        selectedState: null,
        zipcode: null,
        location: null,
        city: [],
        state: []
      }
    },
    methods: {
      resetForm () {
        this.selectedCity =  null
        this.selectedState = null
        this.zipcode = null
        this.location = null
      },
      submit () {
        var params = {
          location: this.location,
          zipcode: this.zipcode,
          city: this.selectedCity,
          state: this.selectedState
        }
        API.addPOI(params).then((response) => {
          console.log(response)
          this.$message({
            message: response.body.message,
            type: 'success'
          })
          this.resetForm()
        }).catch((error) => {
          console.log(error)
        })
      }
    },
    mounted () {
      API.getCity().then((response) => {
        this.city = response.body
        console.log(this.city)
      })
      API.getState().then((response) => {
        this.state = response.body
      })
    }
  }
</script>
