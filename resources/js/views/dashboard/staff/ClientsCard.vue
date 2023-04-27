<template>
  <div>
    <div class="row">
      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header">
            <h5>Shortcuts</h5>
          </div>
          <div class="card-body">

            <div class="row">

              <div class="col-12 col-md-6">
                <RouterLink :to="{ name: 'users-list' }">
                  <div class="info-box mb-3 bg-info">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Clients List</span>
                    </div>
                  </div>
                </RouterLink>
              </div>

              <div class="col-12 col-md-6">
                <RouterLink :to="{ name: 'users-list' }">
                  <div class="info-box mb-3 bg-success">
                    <span class="info-box-icon"><i class="fas fa-user-plus"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Add Client</span>
                    </div>
                  </div>
                </RouterLink>
              </div>

              <div class="col-12 col-md-6">
                <RouterLink :to="{ name: 'users-list' }">
                  <div class="info-box mb-3 bg-warning">
                    <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Transactions List</span>
                    </div>
                  </div>
                </RouterLink>
              </div>

              <div class="col-12 col-md-6">
                <RouterLink :to="{ name: 'users-list' }">
                  <div class="info-box mb-3 bg-secondary">
                    <span class="info-box-icon"><i class="fas fa-file-medical"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Add Transactions</span>
                    </div>
                  </div>
                </RouterLink>
              </div>

            </div>


          </div>

        </div>

        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">New Transactions</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Plan</th>
                  <th>Name</th>
                  <th>Plan</th>
                  <th>More</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in $trans.content">
                  <td>
                    <img :src="row.plan.avatar" alt="Product 1" class="img-circle img-size-32 mr-2"
                      style="width: 30px; height: 30px">
                    {{ row.plan.name }}
                  </td>
                  <td>
                    {{
                      FullNameConvert(row.client.person.lastName, row.client.person.firstName, row.client.person.midName,
                        row.client.person.extName)
                    }}
                  </td>
                  <td class="text-success text-bold">
                    +{{ NumberAddComma(row.amount) }}
                  </td>
                  <td>
                    <a href="#" class="text-warning">
                      <i class="fas fa-receipt"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <RouterLink :to="{ name: 'transactions-all' }" class="btn btn-info m-3 float-right">More</RouterLink>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header border-0">
            <h3 class="card-title">New Clients</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Transacts</th>
                  <th>Plan</th>
                  <th>More</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in $client.content">
                  <td>
                    <img :src="row.avatar" alt="Product 1" class="img-circle img-size-32 mr-2">
                    {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.person.extName)
                    }}
                  </td>
                  <td v-if="row.client_transactions_sum_amount" class="text-success">
                    +{{ NumberAddComma(row.client_transactions_sum_amount || 0) }}
                  </td>
                  <td v-else>0</td>
                  <td>
                    {{ row.plan.name }}
                  </td>
                  <td>
                    <a href="#" class="text-muted">
                      <i class="fas fa-search"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <RouterLink :to="{ name: 'users-list' }" class="btn btn-info m-3 float-right">More</RouterLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useClientStore } from '@/store/clients/clients';
import { useTransactionStore } from '@/store/clients/transactions'
import { FullNameConvert, NumberAddComma } from '@/helpers/converter'

const $client = useClientStore();
const $trans = useTransactionStore();

onMounted(() => {
  $client.GetAPI()
  $trans.query.limit = 4
  $trans.GetAPI()
});
</script>

<style scoped>
a {
  color: black;
}
</style>

