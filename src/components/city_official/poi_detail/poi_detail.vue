<template>
  <div style="text-align: left !important;vertical-align: middle;">

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">Type:</span>
      </div>
      <div class="col-6 reset-col">
        <el-select v-model="selectedType" clearable placeholder="Select Data Type">
          <el-option
            v-for="(item, key) in dataTypes"
            :label="item.Type"
            :value="item.Type">
          </el-option>
        </el-select>
        <span v-show="errors.has('stateSelected')" class="form-text help is-danger"
              style="text-align: left;">{{ errors.first('stateSelected') }}</span>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="text-align: left !important; vertical-align: middle;">Data Value</span>
      </div>
      <div class="col-6 reset-col">
        <div class="row reset-col">
          <div class="col-6 reset-col">
            <el-input name="one" type="number" placeholder="Enter Value" v-model="one"></el-input>
          </div>
          <div class="col-6" style="padding-right:0; margin-right:0;">
            <el-input placeholder="Enter Value" type="number" v-model="two"></el-input>
          </div>
        </div>
      </div>

    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
        <span style="vertical-align: middle;">Time & date</span>
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
        <span style="vertical-align: middle;">Set Flag</span>
      </div>
      <div class="col-6 reset-col">
        <el-switch
          v-model="flag"
          on-text="on"
          @change="onFlag"
          off-text="off">
        </el-switch>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-5 reset-col" style="padding-left:10px; vertical-align: middle;">
      </div>
      <div class="col-6 reset-col">
        <button class="btn btn-primary text-center float-right" style="margin: 0 auto; margin-left: 10px;"
                @click="submit">Apply Filter
        </button>
        <button class="btn btn-danger text-center float-right" style="margin: 0 auto;" @click="reset">Reset Filter
        </button>
      </div>
    </div>

    <div class="row reset-col" style="margin-top:10px; text-align: left;">
      <div class="col-12 reset-col">
        <el-table
          :data="tableData"
          border
          style="width: 100%">
          <el-table-column
            property="Data_type"
            label="Data type"
            sortable
            min-width="33.33%">
          </el-table-column>
          <el-table-column
            property="Value"
            label="Data value"
            sortable
            min-width="33.33%">
          </el-table-column>
          <el-table-column
            property="Date_time"
            label="Time&date of data reading"
            sortable
            min-width="33.33%">
          </el-table-column>
        </el-table>
      </div>
    </div>

  </div>
</template>
<style>
  div.el-input-number {
    width: 100%;
  }
</style>
<script>
  import moment from 'moment'
  import API from '@/apiService/apiService'
  export default {
    data () {
      return {
        one: null,
        flag: null,
        two: null,
        from: null,
        until: null,
        selectedType: null,
        tableData: [],
        dataTypes: []
      }
    },
    methods: {
      resetForm () {
        this.selectedLocation = null
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
      reset () {
        this.one = null
        this.two = null
        this.selectedType = null
        this.from = null
        this.until = null
      },
      onFlag (value) {
        var params = {
          poi: this.$route.params.poi,
          date: moment().format('YYYY/MM/DD hh:mm:ss'),
          flag: (value) ? '1' : '0'
        }
        console.log(params)
        API.setFlag(params).then((response) => {
          console.log(response)
        }).catch((error) => {
          console.log(error)
          this.$message({
            message: error.body ? error.body.message : error.bodyText,
            type: 'error'
          })
        })
      },
      submit () {
        var params = {
          poi: this.$route.params.poi,
          one: this.one,
          two: this.two,
          type: this.selectedType,
          from: this.from,
          to: this.until
        }
        console.log(params)
        API.getPoiDetail(params).then((response) => {
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
      var params = {
        poi: this.$route.params.poi
      }
      console.log(params)
      API.getFlag(params).then((response) => {
        if (response.body[0].Flag === "0") {
          this.flag = false
        } else {
          this.flag = true
        }
      })

    }
  }
</script>
