<template>
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><strong>Top Agent</strong></h3>
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
                <th>Name</th>
                <th>Sales</th>
                <th>Transacts</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, idx,) in $dash.content.topPerformer" :key="row.id">
                <td>
                  <img :src="row.avatar" alt="Product 1" class="img-circle img-size-32 mr-2">
                  {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.person.extName) }}
                </td>
                <td width="200">
                  <small v-if="idx < 5" class="mr-1">
                    <PercentComponent :num1="Number(row.agent_transactions_sum_amount)" :num2="Number($dash.content.topPerformer[idx +
                        1].agent_transactions_sum_amount)" />
                  </small>
                  <small v-else class="mr-1">
                    <PercentComponent :num1="0" :num2="0" />
                  </small>
                  <strong>{{ NumberAddComma(row.agent_transactions_sum_amount) }}</strong>
                </td>
                <td width="150">
                  <small v-if="idx < 5" class="mr-1">
                    <PercentComponent :num1="Number(row.agent_transactions_count)" :num2="Number($dash.content.topPerformer[idx +
                        1].agent_transactions_count)" />
                  </small>
                  <small v-else class="mr-1">
                    <PercentComponent :num1="0" :num2="0" />
                  </small>
                  {{ row.agent_transactions_count }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
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

    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-0">
          <h3 class="card-title"><strong>Organizational Chart</strong></h3>
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
          <img src="https://www.organimi.com/wp-content/uploads/2017/10/Screen-Shot-2017-11-10-at-3.07.34-PM.png"
            style="width: 100%; height: auto" />
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { Bar as BarComponent } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import moment from 'moment'
import { useDashboardStore } from '@/store/dashboard/dashboard'
import { FullNameConvert, NumberAddComma, GetPercentage } from '@/helpers/converter'

import PercentComponent from './PercentComponent.vue'

const $dash = useDashboardStore();
$dash.content.annualIncome = $dash.content.annualIncome.reverse();

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const months = ref([])
for (let i = 0; i < 12; i++) {
  months.value.push(moment().subtract(i, 'months').format("YYYY-MM"))
}
months.value = months.value.reverse()

const _chart = reactive({
  chartData: {
    labels: [...$dash.content.annualIncome.map(m => m.date.slice(0, 3))],
    datasets: [{
      label: 'Income',
      backgroundColor: '#17A2B8',
      data: [...$dash.content.annualIncome.map(m => m.amount)]
    }]
  },
  chartOptions: {
    responsive: true
  }
}
);

const data = ref([
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Schwarzenegger Belonio',
    sale: '12,000',
    clients: 12,
  },
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Juan Deloslos',
    sale: '6,000',
    clients: 6,
  },
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Juan Deloslos',
    sale: '6,000',
    clients: 6,
  },
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Juan Deloslos',
    sale: '6,000',
    clients: 6,
  },
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Juan Deloslos',
    sale: '6,000',
    clients: 6,
  },
  {
    avatar: 'http://127.0.0.1:8000/uploads/1681300488.jpg',
    name: 'Bunhog SDfsdrf',
    sale: '2,000',
    clients: 1,
  },
]);
</script>
