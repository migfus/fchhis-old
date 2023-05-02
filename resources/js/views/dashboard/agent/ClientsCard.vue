<template>
  <div class="col-12 col-md-6">

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
              <input v-model="$down.query.search" type="text" name="table_search" class="form-control float-right"
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
            <tr v-for="row in $down.content">
              <!-- <td>{{ row.person.lastName }}</td> -->
              <td>{{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.person.extName) }}
              </td>
              <td class="text-bold">{{ `${row.plan.name} (${row.pay_type.name})` }}</td>
              <td class="text-success text-bold">{{ NumberAddComma(row.client_transactions_sum_amount) }}</td>
            </tr>
          </tbody>
        </table>



        <!-- <Bootstrap5Pagination :data="$down.content" :limit="2" @pagination-change-page="$down.GetAPI" /> -->
        <button @click="Print()" class="btn btn-sm btn-info float-right">Print</button>
      </div>
    </div>


  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue';
import { useDownHeadStore } from '@/store/dashboard/downhead'
import { throttle } from 'lodash'
import { FullNameConvert, NumberAddComma } from '@/helpers/converter'
import moment from 'moment'
import { ref } from 'vue'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'
import { useAgentClientStore } from '@/store/print/agenClient';
import { useProfileStore } from '@/store/auth/profile';

$DebugInfo("ClientCard")
const $down = useDownHeadStore();
const $print = useAgentClientStore();
const $profile = useProfileStore();
const month = ref(0)

function Print() {
  $print.Print({
    header: {
      name: FullNameConvert($profile.content.person.lastName, $profile.content.person.firstName, $profile.content.person.midName, $profile.content.person.extName)
    },
    body: $down.content.map(m => { return { name: m.person.lastName, plan: m.plan.name, type: m.pay_type.name, amount: m.client_transactions_sum_amount } }),
  })
}

function currentDate(input) {
  month.value += input
  $down.query.start = moment().startOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
  $down.query.end = moment().endOf('month').subtract(month.value, 'months').format('YYYY-MM-DD')
}

onMounted(() => {
  currentDate(0)
  $down.GetAPI()
  $profile.GetAPI()
});

watch($down.query, throttle(() => {
  $down.GetAPI(1)
}, 1000));
</script>
