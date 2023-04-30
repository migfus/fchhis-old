<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><strong>Transactions</strong></h4>

      <!-- <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div> -->

    </div>
    <div class="card-body">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th width="100">OR</th>
            <th>Amount</th>
            <th>Plan</th>
            <th width="100">Date</th>
            <th width="60">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in $dash.content.transactions">
            <td>{{ row.id }}</td>
            <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
            <td class="text-bold">{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
            <td class="">{{ moment(row.created_at).format('MMM D, YYYY HH:mm:ss') }}</td>
            <td>
              <button data-toggle="modal" data-target="#receipt-modal" @click="OpenReceipt(row)"
                class="btn btn-warning btn-sm mr-1 float-right"><i class="fas fa-receipt"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class='mt-3'>
        Total: <strong v-if="$dash.content.sumTransactions" class="text-success">
          {{ NumberAddComma($dash.content.sumTransactions) }}
        </strong>

        <button data-toggle="modal" data-target="#receipt-modal" @click="Print($dash.content.transactions)"
          class="btn btn-success btn-sm mr-1 float-right">Print</button>
      </div>
      <!-- <div>
            To Pay: <strong class="text-orange">78,000.00</strong>
          </div> -->

    </div>
    <ReceiptModal v-if="data" :data="data" />

  </div>
</template>


<script setup>
import { ref } from 'vue'
import moment from 'moment'
import { $DebugInfo, $Log } from '@/helpers/debug'
import { useDashboardStore } from '@/store/dashboard/dashboard'
import { NumberAddComma } from '@/helpers/converter'
import { useTransactionReportStore } from '@/store/print/transactionReport'

import ReceiptModal from '../modals/ReceiptModal.vue'

const $dash = useDashboardStore();
const $report = useTransactionReportStore();

const data = ref(false);

function OpenReceipt(row) {
  $DebugInfo('OpenReceipt')
  $Log('OpenReceipt', { row })
  data.value = row
}

function Print(input) {
  $report.Print({
    header: {
      name: 'testname'
    },
    body: $dash.content.transactions.map(m => { return { plan: m.plan.name, type: m.pay_type.name, amount: m.amount, date: moment(m.created_at).format('MM/DD/YYYY HH:MM A') } }),
  })
}
</script>
