<template>
  <div class="col-12 col-md-6">

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
      <div class="card-body">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th width="100">Name</th>
              <th>Transactions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in $trans.content.data">
              <td>{{ FullNameConvert(row.client.person) }} </td>
              <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
            </tr>
          </tbody>
        </table>
        <div class="text-bold">
          <!-- Total: <span class="text-success">+{{ _sum($trans.content.data, 'amount') }}</span> -->

        </div>

        <button @click="Print()" class="btn btn-sm btn-info float-right">Print</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { useTransactionStore } from '@/store/transaction/transaction'
import { throttle } from 'lodash'
import { FullNameConvert, NumberAddComma, Sum } from '@/helpers/converter'
import moment from 'moment'
import { ref } from 'vue'
import { useAgentTransactionStore } from '@/store/print/agentTransaction'
import { useProfileStore } from '@/store/auth/profile'


const $trans = useTransactionStore();
const $print = useAgentTransactionStore();
const $profile = useProfileStore();

$trans.query.start = moment().startOf('month').format('YYYY-MM-DD')
$trans.query.end = moment().endOf('month').format('YYYY-MM-DD')

const month = ref(0)

function currentDate(input = 0) {
  month.value += input
  $trans.query.start = moment().startOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
  $trans.query.end = moment().endOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
  $trans.GetAPI()
}

function Print() {
  $print.Print({
    header: {
      name: FullNameConvert($profile.content.person)
    },
    body: $trans.content.data.map(m => { return { plan: m.plan.name, type: m.pay_type.name, amount: m.amount, date: moment(m.created_at).format('MM/DD/YYYY HH:MM A') } }),
  })
}

onMounted(() => {
  currentDate();
  $profile.GetAPI()
});

watch($trans.query, throttle(() => {
  $trans.GetAPI(1)
}, 1000));
</script>
