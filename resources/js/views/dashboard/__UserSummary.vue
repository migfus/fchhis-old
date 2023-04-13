<template>
  <div class="row">

    <div class="col-4">
      <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">New Users</h3>
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
            <tr v-for="row in newUsers" :key="row.username">
              <td>
                <img :src="row.avatar" alt="Product 1" class="img-circle img-size-32 mr-2">
                {{  row.username }}
              </td>
              <td>{{ row.email }}</td>
              <td>
                <small class="text-success mr-1">
                  <i class="fas fa-arrow-up"></i>
                  12%
                </small>
                {{  row.price }}
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

    <div class="col-4">
      <div class="card">
      <div class="card-header border-0">
        <h3 class="card-title">Latest Transactions</h3>
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
              <th>Price</th>
              <th>More</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in newTransaction" :key="row.username">
              <td>
                <img :src="row.avatar" alt="Product 1" class="img-circle img-size-32 mr-2">
                {{  row.username }}
              </td>
              <td>{{ row.email }}</td>
              <td>
                <small class="text-success mr-1">
                  <i class="fas fa-arrow-up"></i>
                  12%
                </small>
                {{  row.price }}
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

    <div class="col-4">
      <div class="card">
        <div class="card-header border-0">
          <div class="d-flex justify-content-between">
            <h3 class="card-title">Sales</h3>
            <a href="javascript:void(0);">View Report</a>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex">
            <p class="d-flex flex-column">
              <span class="text-bold text-lg">820,000 ₱</span>
              <span>Current 6 months</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
              <span class="text-success">
                <i class="fas fa-arrow-up"></i> 12.5%
              </span>
              <span class="text-muted">Last 6 Months</span>
            </p>
          </div>

          <div class="position-relative mb-2">
            <Line :data="data" :options="options" style="height: 13em"/>
          </div>

        </div>
        </div>
    </div>


  </div>
</template>

<script setup>
import { ref } from 'vue'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'
import moment from 'moment'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const months = ref([])
for(let i = 0; i < 6; i++) {
  months.value.push(moment().subtract(i, 'months').format("YYYY-MM"))
}
months.value = months.value.reverse()

const options = ref({
  responsive: true,
  maintainAspectRatio: false
})

const data = ref({
  labels: [...months.value.map((v) => moment(v).format('MMM'))],
  datasets: [
    {
      label: 'Current',
      backgroundColor: '#1591A5',
      data: [40, 39, 10, 40, 39, 80, 40]
    },
    {
      label: 'Last Year',
      backgroundColor: '#E5AD06',
      data: [40, 39, 20, 20, 30, 50, 20]
    }
  ]
})

const newUsers = ref([
  {
    username: 'Admin',
    email: 'emailemai@gmail.com',
    price: '12k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Juan',
    email: 'juan@gmail.com',
    price: '14k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Lami',
    email: 'llami@gmail.com',
    price: '15k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Juan',
    email: 'juan@gmail.com',
    price: '14k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Lami',
    email: 'llami@gmail.com',
    price: '15k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
]);

const newTransaction = ref([
  {
    username: 'Admin',
    email: 'emailemai@gmail.com',
    price: '12k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Juan',
    email: 'juan@gmail.com',
    price: '14k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Lami',
    email: 'llami@gmail.com',
    price: '15k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Juan',
    email: 'juan@gmail.com',
    price: '14k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
  {
    username: 'Lami',
    email: 'llami@gmail.com',
    price: '15k',
    avatar: 'https://adminlte.io/themes/v3/dist/img/default-150x150.png'
  },
]);
</script>
