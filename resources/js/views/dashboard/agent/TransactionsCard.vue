<template>
  <div v-if="$trans.content" class="col-12 col-md-6">

    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12 col-md-6">
            <h4 class="card-title mb-3"><strong>{{ moment().subtract(month, 'months').format('MMM YYYY') }}
                Transactions</strong>
            </h4>

          </div>
          <div class="col-12 col-md-6">
            <div class="input-group input-group-sm">
              <input v-model="$trans.query.search" type="text" name="table_search" class="form-control float-right"
                placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>

                <button @click="currentDate(1)" class="btn btn-sm btn-info "><i class="fas fa-arrow-left ml-1"></i> {{
                  moment().subtract(month + 1,
                    'months').format('MMM YYYY') }}</button>
                <button @click="currentDate(-1)" class="btn btn-sm btn-info">{{ moment().subtract(month - 1,
                  'months').format('MMM YYYY') }} <i class="fas fa-arrow-right ml-1"></i></button>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th width="100">Name</th>
              <th>Plan</th>
              <th>Transactions</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in $trans.content.data">
              <td>{{ row.client.name }} </td>
              <td class="text-bold">{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
              <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
              <td class="">{{ moment(row.created_at).format('MM/DD/YYYY') }}</td>
            </tr>
          </tbody>
        </table>
        <div class="text-bold">
          <!-- Total: <span class="text-success">+{{ _sum($trans.content.data, 'amount') }}</span> -->

        </div>

        <div class="row">
          <div class="col-12">
            <Bootstrap5Pagination :data="$trans.content" :limit="2" @pagination-change-page="$trans.GetAPI"
              class="float-right" />
          </div>
        </div>
        <button @click="Print()" class="btn btn-sm btn-info float-right">Print</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, watch, onUnmounted } from 'vue';
import { useTransactionStore } from '@/store/transactions/TransactionStore'
import { throttle } from 'lodash'
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'
import { ref } from 'vue'
import { useAgentTransactionStore } from '@/store/print/agentTransaction'
import { useAuthStore } from '@/store/auth/AuthStore'

import Bootstrap5Pagination from '@/components/Bootstrap5Pagination.vue'

const $trans = useTransactionStore();
const $print = useAgentTransactionStore();
const $auth = useAuthStore()

$trans.query.start = moment().startOf('month').format('YYYY-MM-DD')
$trans.query.end = moment().endOf('month').format('YYYY-MM-DD')

const month = ref(0)

function currentDate(input = 0) {
  month.value += input
  $trans.query.start = moment().startOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
  $trans.query.end = moment().endOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
}

async function Print() {
  await $trans.PrintAPI()

  $print.Print({
    header: {
      name: $auth.content.auth.person.name,
      ip: $auth.content.ip,
      start: moment($trans.query.start).format('MMM D, YYYY'),
      end: moment($trans.query.end).format('MMM D, YYYY')
    },
    body: $trans.print.map(m => {
      console.log(m.client)
      return {
        name: m.client ? m.client.name : '',
        plan: m.plan.name,
        type: m.pay_type.name,
        amount: m.amount,
        date: moment(m.created_at).format('MM/DD/YYYY HH:MM A')
      }
    }),
  })
}

onMounted(() => {
  // currentDate(0);
  console.log('transaction onMounted triggered')
  $trans.GetAPI(1)
});

watch($trans.query, throttle(() => {
  // $trans.GetAPI(1)
  console.log('agent transaction watch triggered')
}, 1000));

onUnmounted(() => {
  $trans.content = []
});
</script>
