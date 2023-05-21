<template>
  <div class="card">
    <div class="card-header border-0">
      <div class="d-flex justify-content-between">
        <h3 class="card-title"><strong>Semi Annual</strong></h3>
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex">
        <p class="d-flex flex-column">
          <span class="text-lg">₱ {{ NumberAddComma($stat.content.semiAnnualTotalIncome.current) }} </span>
          <span>Current 6 months</span>
        </p>
        <p class="ml-auto d-flex flex-column text-right">
          <span class="text-success">
            <i class="fas fa-arrow-up"></i>
            {{ GetPercentage($stat.content.semiAnnualTotalIncome.current,
              $stat.content.semiAnnualTotalIncome.past) }} %
          </span>
          <span class="text-muted">Last 6 Months</span>
        </p>
      </div>

      <div class="position-relative mb-2">
        <Line :data="lineData" :options="options" style="height: 13em" class="chartjs-render-monitor" />
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useStatisticStore } from '@/store/dashboard/StatisticStore'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js'
import { Line } from 'vue-chartjs'

import moment from 'moment'
import { NumberAddComma, GetPercentage } from '@/helpers/converter'

const $stat = useStatisticStore();

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
)

const months = ref([])
for (let i = 0; i < 6; i++) {
  months.value.push(moment().subtract(i, 'months').format("YYYY-MM"))
}
months.value = months.value.reverse()

const options = ref({
  responsive: true,
  maintainAspectRatio: false,
  bezierCurve: true,
})

if ($stat.content.currentSemiAnnual) {
  $stat.content.currentSemiAnnual = $stat.content.currentSemiAnnual.slice().reverse()
  $stat.content.pastSemiAnnual = $stat.content.pastSemiAnnual.slice().reverse()
}

const lineData = ref({
  labels: [...$stat.content.currentSemiAnnual.map(m => m.date.slice(0, 3))],

  datasets: [
    {
      label: 'Current',
      backgroundColor: '#1591A5',
      borderColor: '#17A2B8',
      data: [...$stat.content.currentSemiAnnual.map(m => m.amount)],
      tension: .2,
    },
    {
      label: 'Last Year',
      backgroundColor: '#E5AD06',
      borderColor: '#FFC107',
      data: [...$stat.content.pastSemiAnnual.map(m => m.amount)],
      tension: .2,
    }
  ]
});

</script>
