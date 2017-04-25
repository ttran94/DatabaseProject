<template>
  <div style="text-align: left !important;vertical-align: middle;">
    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="font-size:12px; text-align: left !important; vertical-align: middle;">POI Location Name</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedLocation" clearable placeholder="Select">
          <el-option
            v-for="(item, key) in locations"
            :label="item.Location_name"
            :value="item.Location_name">
          </el-option>
        </el-select>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:5px; text-align: left;;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">City:</span>
      </div>
      <div class="col-6 reset-col" >
        <el-select v-model="selectedCity" clearable placeholder="Select City">
          <el-option
            v-for="(item, key) in cities"
            :label="item.City"
            :value="item.City">
          </el-option>
        </el-select>
        <span v-show="errors.has('citySelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('citySelected') }}</span>

      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">State:</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedState" clearable placeholder="Select State">
          <el-option
            v-for="(item, key) in states"
            :label="item.State"
            :value="item.State">
          </el-option>
        </el-select>
        <span v-show="errors.has('stateSelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('stateSelected') }}</span>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">Flag:</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedFlag" clearable placeholder="Select Flag Option">
          <el-option
            v-for="(item, key) in flags"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <span v-show="errors.has('stateSelected')" class="form-text help is-danger" style="text-align: left;">{{ errors.first('stateSelected') }}</span>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="text-align: left !important; vertical-align: middle;">Zip Code</span>
      </div>
      <div class="col-6 reset-col">
        <el-input placeholder="Zip Code" v-model="value"></el-input>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">Date flagged:</span>
      </div>
      <div class="col-6 reset-col">
        <div class="row reset-col">
          <div class="col-6 reset-col">
            <el-date-picker
              v-model="from"
              type="datetime"
              format="yyyy/MM/dd HH:mm"
              placeholder="Select date and time">
            </el-date-picker>
          </div>
          <div class="col-6" style="margin-right:0; padding-right: 0;">
            <el-date-picker
              v-model="until"
              type="datetime"
              format="yyyy/MM/dd HH:mm"
              placeholder="Select date and time">
            </el-date-picker>
          </div>
        </div>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
      </div>
      <div class="col-6 reset-col">
        <button class="btn btn-primary text-center float-right" style="margin: 0 auto; margin-left: 10px;" @click="submit">Apply Filter</button>
        <button class="btn btn-danger text-center float-right" style="margin: 0 auto;" @click="reset">Reset Filter</button>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-12 reset-col">
        <el-table
          :data="tableData"
          border
          @row-click="getRow"
          style="width: 100%">
          <el-table-column
            property="Location_name"
            sortable
            label="Location Name"
            min-width="16.666%">
          </el-table-column>
          <el-table-column
            property="POI_city"
            label="City"
            sortable
            min-width="16.666%">
          </el-table-column>
          <el-table-column
            property="POI_state"
            label="State"
            sortable
            min-width="16.666%">
          </el-table-column>
          <el-table-column
            property="Zipcode"
            label="Zip Code"
            sortable
            min-width="16.666%">
          </el-table-column>
          <el-table-column
            property="Flag"
            label="Flagged?"
            sortable
            min-width="16.666%">
          </el-table-column>
          <el-table-column
            property="Date_flagged"
            label="Date Flagged"
            sortable
            min-width="16.666%">
            <template scope="scope">
              <span style="margin-left: 10px">{{ getDate(scope.row.Date_flagged) }}</span>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>

  </div>
</template>
<style>

</style>
<script>
  import moment from 'moment'
  import API from '@/apiService/apiService'
  export default {
    data () {
      return {
        selectedDatetime: null,
        selectedLocation: null,
        selectedType: null,
        selectedCity: null,
        from: null,
        until: null,
        selectedState: null,
        cities: [],
        selectedFlag: '',
        tableData: [],
        states: [],
        value: null,
        locations: [],
        dataTypes: [],
        flags: [
          {
            label: "True",
            value: 1
          },
          {
            label: "False",
            value: 0
          }
        ]
      }
    },
    methods: {
      resetForm () {
        this.selectedLocation = null
      },
      reset () {
        this.selectedLocation = null
        this.selectedCity = null
        this.selectedState = null
        this.selectedFlag = null
        this.value = null
        this.from = null
        this.until = null
        this.submit()
      },
      getRow (data) {
        this.$router.push({name: 'POIDetail', params: {poi: data.Location_name}})
      },
      getDate (date) {
        if (date) {
          return moment(date).format('YYYY/MM/DD')
        } else {
          return 'N/A'
        }
      },
      submit () {
        var params = {
          location: this.selectedLocation,
          city: this.selectedCity,
          state: this.selectedState,
          flag: this.selectedFlag,
          zipcode: this.value,
          from: this.from,
          to: this.until
        }
        API.getPoiFilter(params).then((response) => {
          console.log(response)
          console.log(response.body.data)
          this.tableData = response.body.data || []
          this.$message({
            message: response.body.message,
            type: 'success'
          })
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
      this.submit()
      API.getDataTypes().then((response) => {
        this.dataTypes = response.body
      })
      API.getLocations().then((response) => {
        this.locations = response.body
      })
      API.getCity().then((response) => {
        console.log(response)
        this.cities = response.body
      })
      API.getState().then((response) => {
        this.states = response.body
      })
    }
  }
</script>
