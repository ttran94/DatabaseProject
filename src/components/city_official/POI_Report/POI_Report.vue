<template>
  <div class="row reset-col" style="overflow-x:scroll; overflow-y:scroll;">
    <el-table
      :data="tableData"
      border
      style="width: 100%">
      <el-table-column
        property="POI Location"
        sortable
        label="POI Location">
      </el-table-column>
      <el-table-column
        property="City"
        sortable
        label="City">
      </el-table-column>
      <el-table-column
        property="State"
        label="State"
        sortable>
      </el-table-column>
      <el-table-column
        property="Mold MIN"
        label="Mold MIN"
        sortable>
      </el-table-column>
      <el-table-column
        property="Mold AVG"
        label="Mold Avg"
        sortable>
      </el-table-column>
      <el-table-column
        property="Mold MAX"
        label="Mold Max"
        sortable>
      </el-table-column>
      <el-table-column
        property="AQ MIN"
        label="AQ Min"
        sortable>
      </el-table-column>
      <el-table-column
        property="AQ AVG"
        label="AQ Avg"
        sortable>
      </el-table-column>
      <el-table-column
        property="AQ MAX"
        label="AQ Max"
        sortable>
      </el-table-column>
      <el-table-column
        property="#of data points"
        label="#of data points"
        sortable>
      </el-table-column>
      <el-table-column
        property="Flagged"
        label="Flagged?"
        sortable>
      </el-table-column>
    </el-table>
    <div class="row reset-col text-center" style="margin: 0 auto; margin-top: 20px; margin-bottom: 20px;">
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
        API.getPoiReport().then((response) => {
          console.log(response)
          this.tableData = response.body
        })
      }
    },
    mounted () {
      this.getData()
    }
  }
</script>
