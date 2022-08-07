<template>
<q-page>
  <div class="row">
    <div class="col-12 col-md-6">
      <Bar :chart-data="chartData" />
    </div>
    <div class="col-12 col-md-6">
      <Bar :chart-data="usersChartData" />
    </div>
  </div>

</q-page>
</template>
<script>
import { Bar } from 'vue-chartjs'
// import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

// ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
import Chart from 'chart.js/auto';
import {CategoryScale} from 'chart.js';
Chart.register(CategoryScale);
export default {
  name: 'BarChart',
  components: { Bar },
  data() {
    return {
      chartData: {
        // labels: [ 'January', 'February', 'March'],
        datasets: [
          {
            label: 'Registro por edad',
            backgroundColor: '#f87979',
            // data: [40, 20, 12]
          }
        ]
      },
      usersChartData: {
        // labels: [ 'January', 'February', 'March'],
        datasets: [
          {
            label: 'Registro por usuario',
            backgroundColor: 'rgb(33,150,243)',
            // data: [40, 20, 12]
          }
        ]
      },

    }
  },
  created() {
    this.$api.post('consultaEdades').then(res => {
      this.chartData.datasets[0].data=[]
      this.chartData.labels=[]
      res.data.forEach(r => {
        this.chartData.datasets[0].data.push(r.cantidad)
        this.chartData.labels.push('Edad '+r.edad)
      });
    })
    this.$api.post('consultaUsers').then(res => {
      this.usersChartData.datasets[0].data=[]
      this.usersChartData.labels=[]
      res.data.forEach(r => {
        this.usersChartData.datasets[0].data.push(r.cantidad)
        this.usersChartData.labels.push(r.name.split(' ')[0])
      });
    })
  }
}
</script>

<style scoped>

</style>
