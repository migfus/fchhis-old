<template>
  <div v-if="$users.content" class="col-12 col-md-6">

    <div class="card table-responsive">
      <div class="card-header">
        <div class="row">
          <div class="col-12 col-md-6">
            <h4 class="card-title mb-3"><strong>{{ moment().subtract(month, 'months').format('MMM YYYY') }}
                Clients</strong>
            </h4>

          </div>
          <div class="col-12 col-md-6">
            <div class="input-group input-group-sm">
              <input v-model="$users.query.search" type="text" name="table_search" class="form-control float-right"
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
              <th>Plan</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in $users.content.data">
              <!-- <td>{{ row.person.lastName }}</td> -->
              <td>{{ row.name }}
              </td>
              <td class="text-bold">{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
              <td class="text-success text-bold">{{ NumberAddComma(row.client_transactions_sum_amount) }}</td>
            </tr>
          </tbody>
        </table>


        <div class="row">
          <div class="col-12">
            <Bootstrap5Pagination :data="$users.content" :limit="2" @pagination-change-page="$users.GetAPI"
              class="float-right" />
          </div>
        </div>

        <button @click="Print()" class="btn btn-sm btn-info float-right">Print</button>
      </div>
    </div>


  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { throttle } from 'lodash'
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'
import { ref } from 'vue'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'
import { useUsersStore } from '@/store/users/UsersStore';
import { useAuthStore } from '@/store/auth/AuthStore';
import { useAgentClientStore } from './../../../store/agent/agentClient';

import Bootstrap5Pagination from './../../../components/Bootstrap5Pagination.vue'

$DebugInfo("ClientCard")
const $users = useUsersStore();
const $print = useAgentClientStore();
const $auth = useAuthStore()
const month = ref(0)

async function Print() {
  await $users.PrintAPI();

  $print.Print({
    header: {
      name: $auth.content.person.name
    },
    body: $users.print.map(m => { return { name: m.person.lastName, plan: m.plan.name, type: m.pay_type.name, amount: m.client_transactions_sum_amount } }),
  })
}

function currentDate(input) {
  month.value += input
  $users.query.start = moment().startOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
  $users.query.end = moment().endOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
}

onMounted(() => {
  currentDate(0)
  $users.GetAPI()
});

watch($users.query, throttle(() => {
  $users.GetAPI(1)
}, 1000));
</script>
