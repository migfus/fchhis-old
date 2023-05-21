<template>
  <div v-if="$trans.content" class="card">
    <div class="card-header">
      <h3 class="card-title text-bold">New Transactions</h3>
    </div>

    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Accumulated</th>
            <th>Agent</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in $trans.content.data">
            <td>{{ row.client.name }}</td>
            <td>
              <strong class="text-success">
                +{{ NumberAddComma(row.amount) }}
              </strong>
            </td>
            <td>
              <strong class="text-success">
                {{ row.agent.name }}
              </strong>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { useTransactionStore } from '@/store/transactions/TransactionStore'
import { onMounted } from 'vue'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $trans = useTransactionStore();

onMounted(() => {
  $trans.query.limit = 11;
  $trans.query.start = moment().startOf('month')
  $trans.query.end = moment().endOf('month')
  $trans.GetAPI()
})

// onUnmounted(() => {
//   $trans.content = []
// });
</script>
