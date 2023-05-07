<template>
  <div class="row">

    <div class="col-md-6 col-xl-4">
      <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><strong>New Users</strong></h3>
          <div class="card-tools">
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-download"></i>
            </a>
            <a href="#" class="btn btn-tool btn-sm">
              <i class="fas fa-bars"></i>
            </a>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>More</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in $dash.content.newUsers" :key="row.username">
                <td>
                  <img :src="row.avatar || 'https://fchhis.migfus20.com/images/logo.png'" alt="Product 1"
                    class="img-circle img-size-32 mr-2">
                  {{ row.username }}
                </td>
                <td>{{ row.email }}</td>
                <td>
                  {{ RoleToDesc(row.role) }}
                </td>
                <td>
                  <a href="#" class="text-muted">
                    <i class="fas fa-search"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="card">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between">
            <h3 class="card-title"><strong>User's Role</strong></h3>
            <a href="javascript:void(0);">View Report</a>
          </div>
        </div>
        <div class="card-body">

          <div class="position-relative mb-2">
            <Doughnut :data="dougData" :options="{ responsive: true, maintainAspectRatio: false }" />
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="card">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between">
            <h3 class="card-title"><strong>Semi Annual</strong></h3>
            <a href="javascript:void(0);">View Report</a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column">
              <span class="text-lg">₱ {{ NumberAddComma($dash.content.semiAnnualTotalIncome.current) }} </span>
              <span>Current 6 months</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
              <span class="text-success">
                <i class="fas fa-arrow-up"></i>
                {{ GetPercentage($dash.content.semiAnnualTotalIncome.current,
                  $dash.content.semiAnnualTotalIncome.past) }} %
              </span>
              <span class="text-muted">Last 6 Months</span>
            </p>
          </div>

          <div class="position-relative mb-2">
            <Line :data="lineData" :options="options" style="height: 13em" class="chartjs-render-monitor" />
          </div>

        </div>
      </div>
    </div>


  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useDashboardStore } from '@/store/dashboard/dashboard'
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
import { Line, Doughnut } from 'vue-chartjs'
import moment from 'moment'
import { RoleToDesc } from '@/helpers/converter'
import { NumberAddComma, GetPercentage } from '@/helpers/converter'

const $dash = useDashboardStore();

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

$dash.content.currentSemiAnnual = $dash.content.currentSemiAnnual.reverse()
$dash.content.pastSemiAnnual = $dash.content.pastSemiAnnual.reverse()

const lineData = ref({
  labels: [...$dash.content.currentSemiAnnual.map(m => m.date.slice(0, 3))],

  datasets: [
    {
      label: 'Current',
      backgroundColor: '#1591A5',
      borderColor: '#17A2B8',
      data: [...$dash.content.currentSemiAnnual.map(m => m.amount)],
      tension: .2,
    },
    {
      label: 'Last Year',
      backgroundColor: '#E5AD06',
      borderColor: '#FFC107',
      data: [...$dash.content.pastSemiAnnual.map(m => m.amount)],
      tension: .2,
    }
  ]
})

const dougData = ref({
  labels: [...$dash.content.rolesChart.map((f) => f.name)],
  datasets: [
    {
      backgroundColor: [
        '#28A745', //client
        '#17A2B8', //staff
        '#6F42C1', //agent
        '#FD7E14', //manager
        '#FFC107', //admin
        '#DC3545', //banned
        '#6C757D', //inactive
      ],
      data: [...$dash.content.rolesChart.map((f) => f.count)]
    }
  ]
});


</script>
