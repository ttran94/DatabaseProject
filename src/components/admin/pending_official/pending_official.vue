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
        property="Username"
        sortable
        label="Username"
        min-width="18.5%">
      </el-table-column>
      <el-table-column
        property="Email"
        label="Email"
        sortable
        min-width="18.5%">
      </el-table-column>
      <el-table-column
        property="Official_city"
        label="City"
        sortable
        min-width="18.5%">
      </el-table-column>
      <el-table-column
        property="Official_state"
        label="State"
        sortable
        min-width="18.5%">
      </el-table-column>
      <el-table-column
        property="Title"
        label="Title"
        sortable
        min-width="18.5%">
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
        API.getPendingOfficial().then((response) => {
          console.log(response)
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
        API.ApproveOfficial(params).then((response) => {
          console.log(response)
          this.getData()
          this.$message({
            message: 'Successfully Rejected Pending Official',
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
        API.RejectOfficial(params).then((response) => {
          console.log(response)
          this.getData()
          this.$message({
            message: 'Successfully Rejected Pending Official',
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
