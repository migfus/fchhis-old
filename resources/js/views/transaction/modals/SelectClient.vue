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

            <table class="table table-bordered">
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
                    {{
                      FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.person.extName)
                    }}
                  </td>
                  <td>{{ row.plan.name }}</td>
                  <td>
                    1,000.00
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
import { throttle } from 'lodash'
import { FullNameConvert } from '@/helpers/converter'
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

watch($user.params, throttle(() => {
  $user.GetAPI(1)
}, 1000))

onMounted(() => {
  $user.params.role = 6
  $user.GetAPI()
});
</script>
