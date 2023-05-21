<template>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Transactions</h3>
    </div>

    <div v-if="$trans.content" class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Plan</th>
            <th>Amount</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in $trans.content.data">
            <td>{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
            <td>{{ row.amount }}</td>
            <td>{{ moment(row.created_at).format('MMM D, YYYY') }}</td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import { onMounted, onUnmounted } from 'vue'
import { useTransactionStore } from '@/store/transactions/TransactionStore';
import moment from 'moment'

const $route = useRoute();
const $trans = useTransactionStore();

onMounted(() => {
  $trans.query.id = $route.params.id
  $trans.GetAPI()
});

onUnmounted(() => {
  $trans.query.id = null
  $trans.content = []
});
</script>
