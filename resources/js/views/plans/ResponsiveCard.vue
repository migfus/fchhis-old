<template>
  <div v-for="row in $plan.content" :key="row.id" class="col-md-6 col-12">


    <div :class="`card mb-2`">
      <div class="card-header">
        <div>
          <div class="row">
            <div class="col-12">
              <div class="card-tools float-right">
                <button :disabled="!$plan.config.enableDelete" @click="$plan.DeleteAPI(row.id, idx)"
                  class="btn btn-danger btn-sm float-right">
                  Remove
                </button>
                <button @click="$plan.Update(row)" class="btn btn-secondary btn-sm float-right mr-1">
                  Edit
                </button>
              </div>

              <img v-if="row.avatar" :src="row.avatar" style="height: 2.5em; width: 2.5em"
                class="img-circle float-left mr-3">
              <div> <strong> {{ row.name }} </strong> </div>

              <div>{{ moment(row.created_at).local().format('MMMD, YYYY') }}</div>
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
      </div>

    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePlanStore } from '@/store/system/plan';
import moment from 'moment';
import { NumberAddComma } from '@/helpers/converter'

const $plan = usePlanStore();

onMounted(() => {
  $plan.GetAPI()
});


</script>
