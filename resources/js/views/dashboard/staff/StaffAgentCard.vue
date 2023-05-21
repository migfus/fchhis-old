<template>
  <div v-if="$users.content" class="card">
    <div class="card-header">
      <h3 class="card-title text-bold">New Clients</h3>
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
          <tr v-for="row in $users.content.data">
            <td>{{ row.name }}</td>
            <td>
              <strong class="text-success">
                +{{ NumberAddComma(row.client_transactions_sum_amount) }}
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
import { useUsersStore } from '@/store/users/UsersStore'
import { onMounted, onUnmounted } from 'vue'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $users = useUsersStore();

onMounted(() => {
  $users.query.limit = 5;
  $users.query.role = 6;
  $users.GetAPI()
})

onUnmounted(() => {
  $users.content = []
});
</script>
