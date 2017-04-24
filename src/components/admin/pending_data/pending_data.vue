<template>
  <div class="row reset-col" style="overflow-x:scroll; overflow-y:scroll;">
    <el-table
      :data="tableData"
      border
      style="width: 100%"
      @selection-change="handleSelectionChange">
      <el-table-column
        type="selection"
        min-width="3%">
      </el-table-column>
      <el-table-column
        property="POI_name"
        sortable
        label="POI location"
        min-width="20%">
      </el-table-column>
      <el-table-column
        property="Data_type"
        label="Data type"
        sortable
        min-width="20%">
      </el-table-column>
      <el-table-column
        property="POI_name"
        label="Data value"
        sortable
        min-width="20%">
      </el-table-column>
      <el-table-column
        property="Date_time"
        label="Time&date of data reading"
        sortable
        min-width="20%">
      </el-table-column>
    </el-table>
    <div class="row reset-col text-center" style="margin: 0 auto; margin-top: 20px; margin-bottom: 20px;">
      <el-button type="danger" @click="reject">Reject</el-button>
      <el-button type="info" @click="approve">Accept</el-button>
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
        tableData: [],
        data: {},
        columns: [
          {
            prop: 'date',
            label: 'Date'
          },
          {
            prop: 'name',
            label: 'Name'
          }
        ]
      }
    },
    methods: {
      getData () {
        API.getPendingDataPoint().then((response) => {
          this.tableData = response.body
        })
      },
      handleSelectionChange(val) {
        this.data = val
        console.log(this.data)
      },
      approve () {
        var params = {
          data: this.data
        }
        API.ApprovePending(params).then((response) => {
          console.log(response)
          this.getData()
          this.$message({
            message: 'Successfully Rejected Pending Data',
            type: 'success'
          })
        }).catch((error) => {
          this.$message({
            message: error.body ? error.body.message : error.bodyText,
            type: 'error'
          })
        })
      },
      reject () {
        var params = {
          data: this.data
        }
        API.RejectPending(params).then((response) => {
          console.log(response)
          this.getData()
          this.$message({
            message: 'Successfully Rejected Pending Data',
            type: 'success'
          })
        }).catch((error) => {
          this.$message({
            message: error.body ? error.body.message : error.bodyText,
            type: 'error'
          })
        })
      }
    },
    mounted () {
      this.getData()
    }
  }
</script>
