<template>
  <div>
    <div class="modal fade" id="modal-client">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Select Client</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label for="s-input">Search Name</label>
              <input v-model="$user.params.search" type="text" class="form-control" id="s-input" placeholder="Search" />
            </div>

            <div v-if="$user.config.loading" class="m-5">
              <i class="h1 fas fa-spin fa-spinner"></i>
            </div>
            <table v-else class="table table-bordered">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Plan</th>
                  <th>Accumulated</th>
                  <th style="width: 40px">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in $user.list.data" :key="row.id">
                  <td>
                    {{ row.person.name }}
                  </td>
                  <td>{{ row.plan.name }}</td>
                  <td>
                    <!-- {{ NumberAddComma(row.transaction) }} -->
                  </td>
                  <td>
                    <button @click="Select(row)" type="button" class="btn btn-success btn-sm" data-dismiss="modal"
                      aria-label="Close">
                      Select
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { onMounted, watch } from 'vue'
import { useUserStore } from '@/store/users/users'
import { debounce } from 'lodash'
import { useTransactionStore } from '@/store/transaction/transaction'
import { PlanToAmount } from '@/helpers/converter'

const $user = useUserStore();
const $trans = useTransactionStore();

function Select(row) {
  $trans.params.client = row
  $trans.params.agent = row.person.referred
  $trans.params.plan = row.plan
  $trans.params.pay_type_id = row.pay_type_id

  $trans.params.amount = PlanToAmount(row.pay_type_id, row.plan)
}

watch($user.params, debounce(() => {
  $user.GetAPI(1)
  console.log('select client watch trigger')
}, 1000))

onMounted(() => {
  $user.params.role = 6
});
</script>
