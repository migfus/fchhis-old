<template>
  <div class="card">
    <div class="card-header border-0">
      <h3 class="card-title"><strong>Annual Income</strong></h3>
      <div class="card-tools">
        <a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-download"></i>
        </a>
        <a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-bars"></i>
        </a>
      </div>
    </div>
    <div class="card-body">
      <BarComponent :options="_chart.chartOptions" :data="_chart.chartData" />
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Bar as BarComponent } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import moment from 'moment'
import { useStatisticStore } from '@/store/dashboard/StatisticStore'

const $stat = useStatisticStore();
$stat.content.annualIncome = $stat.content.annualIncome.slice().reverse();

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const months = ref([])
for (let i = 0; i < 12; i++) {
  months.value.push(moment().subtract(i, 'months').format("YYYY-MM"))
}
months.value = months.value.reverse()

const _chart = reactive({
  chartData: {
    labels: [...$stat.content.annualIncome.map(m => m.date.slice(0, 3))],
    datasets: [{
      label: 'Income',
      backgroundColor: '#17A2B8',
      data: [...$stat.content.annualIncome.map(m => m.amount)]
    }]
  },
  chartOptions: {
    responsive: true
  }
}
);
</script>
