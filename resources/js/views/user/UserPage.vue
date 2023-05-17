<template>
  <div v-if="userContent" class="row" :style="`background-image: url(${dead})`">
    <div class="col-12 col-md-5">

      <div class="card card-widget widget-user">

        <div class="widget-user-header text-white"
          style="background: url('https://adminlte.io/themes/v3/dist/img/photo1.png') center center;">
          <h3 class="widget-user-username text-right">
            {{
              FullNameConvert(userContent.person)
            }}
          </h3>
          <h5 class="widget-user-desc text-right">{{ userContent.email }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle" :src="userContent.avatar" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-3 border-right">
              <div class="description-block">
                <h5 class="description-header">Client</h5>
                <span class="description-text">User</span>
              </div>

            </div>
            <div class="col-sm-3 border-right">
              <div class="description-block">
                <h5 class="description-header">{{ userContent.plan.name }}</h5>
                <span class="description-text">Plan</span>
              </div>

            </div>

            <div class="col-sm-3 border-right">
              <div class="description-block">
                <h5 class="description-header text-success">{{
                  NumberAddComma(userContent.client_transactions_sum_amount) }}
                </h5>
                <span class="description-text">Payed</span>
              </div>

            </div>

            <div class="col-sm-3">
              <div class="description-block">
                <h5 class="description-header text-danger">
                  {{
                    NumberAddComma(
                      userContentclient_transactions_sum_amount -
                      PlanToPay(userContent.pay_type, userContent.plan)
                    )
                  }}
                </h5>
                <span class="description-text">Due Balance</span>
              </div>

            </div>

          </div>

        </div>

        <div class="row m-2">
          <div class="col-12">
            <div class="form-group">
              <label>Diseased</label>
              <select v-model="dead" class="form-control">
                <option :value="false">N/A</option>
                <option :value="'blue'">In Heaven</option>
                <option
                  :value="'https://static.wikia.nocookie.net/evil/images/4/42/The_Hell.jpg/revision/latest/scale-to-width-down/1200?cb=20151219215041'">
                  In Hell</option>
                <option :value="false">Reincarnated</option>
                <option></option>
              </select>
            </div>
          </div>
        </div>

      </div>

      <BeneficiaryTable />

    </div>

    <div class="col-12 col-md-7">
      <TransactionTable />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { FullNameConvert, NumberAddComma, PlanToPay } from '@/helpers/converter'
import { ref, reactive } from 'vue'
import axios from 'axios'

import TransactionTable from './TransactionTable.vue'
import BeneficiaryTable from './BeneficiaryTable.vue'

const $route = useRoute();

const userContent = ref(false)
const config = reactive({
  loading: false,
})

async function GetAPI(id) {
  config.loading = true
  try {
    let { data: { data } } = await axios.get('/api/users/' + id)
    userContent.value = data
  }
  catch (e) {
    $Err('User Details GetAPI', { e })
  }
  config.loading = false
}

onMounted(() => {
  GetAPI($route.params.id)
});
</script>
