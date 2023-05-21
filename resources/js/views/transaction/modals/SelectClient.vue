<template>
  <div>
    <div v-if="$user.content" class="modal fade" id="modal-client">
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
              <input v-model="$user.query.search" type="text" class="form-control" id="s-input" placeholder="Search" />
            </div>

            <div v-if="$user.config.loading" class="m-5">
              <i class="fas fa-circle-notch fa-spin" style="font-size: 3em"></i>
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
                <tr v-for="row in $user.content.data" :key="row.id">
                  <td>
                    {{ row.name }}
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
import { useUsersStore } from '@/store/users/UsersStore'
import { throttle } from 'lodash'
import { useTransactionStore } from '@/store/transactions/TransactionStore'
import { PlanToAmount } from '@/helpers/converter'

const $user = useUsersStore();
const $trans = useTransactionStore();

function Select(row) {
  $trans.params.client = row
  $trans.params.agent = row.agent
  $trans.params.plan = row.plan
  $trans.params.pay_type_id = row.pay_type_id

  $trans.params.amount = PlanToAmount(row.pay_type_id, row.plan)
}

watch($user.query, throttle(() => {
  $user.GetAPI(1)
}, 1000));
</script>
