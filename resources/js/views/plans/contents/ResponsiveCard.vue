<template>
  <div v-for="row in $plan.content" :key="row.id" class="col-12">
    <div :class="`card mb-2 collapsed-card`" data-card-widget="collapse" ref="collapse-click" style="cursor: pointer;">
      <div class="card-header">
        <div>
          <div class="row">

            <div class="col-12 col-md-6 col-xl-4">
              <img v-if="row.avatar" :src="row.avatar" style="height: 2.5em; width: 2.5em"
                class="img-circle float-left mr-3">
              <span class="float-right text-secondary d-md-none">
                {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div> <strong> {{ row.name }} </strong> </div>

            </div>

            <div class="col-12 col-md-6 col-xl-4 d-none d-md-inline">
              <div class="text-bold">Description:</div>
              <span class="float-right text-secondary d-none d-md-inline d-xl-none">
                {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div class="text-truncate" v-html="row.desc"></div>
            </div>

            <div class="col-12 col-xl-4 d-none d-xl-inline">
              <span class="float-right text-secondary">
                {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div class="text-bold">Requirements:</div>
              <strong>{{ `${row.age_start} - ${row.age_end} Years Old` }}</strong>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12">
            <div>Description: </div>
            <div v-html="row.desc"></div>
            <hr />
          </div>
          <div class="col-12">
            <div>Requirements: </div>
            <strong>{{ `${row.age_start} - ${row.age_end} Years Old` }}</strong>
            <hr class="mt-1" />
          </div>
          <div class="col-12">
            <div>Contract Price: <strong>{{ NumberAddComma(row.contract_price) }}</strong></div>
            <div>Spot Payment: <strong>{{ NumberAddComma(row.spot_pay) }}</strong></div>
            <div>Spot Service: <strong>{{ NumberAddComma(row.spot_service) }}</strong></div>
            <div>Annual: <strong>{{ NumberAddComma(row.annual) }}</strong></div>
            <div>Semi-Annual: <strong>{{ NumberAddComma(row.semi_annual) }}</strong></div>
            <div>Quarterly: <strong>{{ NumberAddComma(row.quarterly) }}</strong></div>
            <div>Monthly: <strong>{{ NumberAddComma(row.monthly) }}</strong></div>
          </div>

        </div>

        <div class="card-tools float-right">
          <button :disabled="!$plan.config.enableDelete" @click="$plan.DeleteAPI(row.id, idx)"
            class="btn btn-danger float-right">
            <i class="fas fa-times mr-2"></i>Remove
          </button>
          <button @click="$plan.Update(row)" class="btn btn-warning float-right mr-1">
            <i class="fas fa-pen mr-2"></i>Edit
          </button>

          <button class="btn btn-info float-right mr-1">
            <i class="fas fa-print mr-2"></i>Print
          </button>
        </div>
      </div>

    </div>

    <PrintModal />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePlanStore } from '@/store/system/PlanStore';
import moment from 'moment';
import { NumberAddComma } from '@/helpers/converter'

import PrintModal from '../modals/PrintModal.vue'

const $plan = usePlanStore();

onMounted(() => {
  $plan.GetAPI()
});
</script>
