<template>
  <div v-if="$user.content.user" class="row" :style="`background-image: url(${dead})`">
    <div class="col-12 col-md-5">

      <div class="card card-widget widget-user">

        <div class="widget-user-header text-white"
          style="background: url('https://adminlte.io/themes/v3/dist/img/photo1.png') center center;">
          <h3 class="widget-user-username text-right">
            {{ $user.content.name }}
          </h3>
          <h5 class="widget-user-desc text-right">{{ $user.content.user.email }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle" :src="$user.content.user.avatar" alt="User Avatar">
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
                <h5 v-if="$user.content.plan" class="description-header">{{ $user.content.plan.name }}</h5>
                <span class="description-text">Plan</span>
              </div>

            </div>

            <div class="col-sm-3 border-right">
              <div class="description-block">
                <h5 class="description-header text-success">
                  {{ NumberAddComma($user.content.client_transactions_sum_amount) }}
                </h5>
                <span class="description-text">Payed</span>
              </div>

            </div>

            <div class="col-sm-3">
              <div class="description-block">
                <h5 class="description-header text-danger">
                  {{
                    NumberAddComma(
                      $user.content.client_transactions_sum_amount -
                      PlanToPay($user.content.pay_type, $user.content.plan)
                    )
                  }}
                </h5>
                <span class="description-text">Due Balance</span>
              </div>
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
import { onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { NumberAddComma, PlanToPay } from '@/helpers/converter'
import { useUserDetailsStore } from '@/store/user/UserDetailStore'

import TransactionTable from './TransactionTable.vue'
import BeneficiaryTable from './BeneficiaryTable.vue'

const $route = useRoute();
const $user = useUserDetailsStore();

onMounted(() => {
  $user.GetAPI($route.params.id)
});
onUnmounted(() => {
  $user.content = {}
});
</script>
