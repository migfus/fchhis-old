<template>
  <div>
    <div class="modal fade" id="modal-agent">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Select Agent</h4>
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
                    <!-- {{ row.}} -->
                  </td>
                  <td>
                    <button @click="$trans.params.agent = row" type="button" class="btn btn-info btn-sm"
                      data-dismiss="modal" aria-label="Close">
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

const $user = useUserStore();
const $trans = useTransactionStore();

watch($user.params, debounce(() => {
  $user.GetAPI(1)
  console.log('select agent watch trigger')
}, 1000))

onMounted(() => {
  $user.params.role = 4
});
</script>
