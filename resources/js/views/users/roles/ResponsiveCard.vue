<template>
  <div v-for="row in $role.content" :key="row.id" class="col-md-6 col-12">


    <div :class="`card mb-2`">
      <div class="card-header">
        <div>
          <div class="row">
            <div class="col-12">
              <div class="card-tools float-right">
                <button class="btn btn-secondary btn-sm float-right mr-1">
                  Clients
                </button>
              </div>

              <!-- <img v-if="row.avatar" :src="row.avatar" style="height: 2.5em; width: 2.5em"
                class="img-circle float-left mr-3"> -->
              <!-- <div> <strong> {{ row.name }} </strong> </div> -->

              <!-- <div>{{ moment(row.created_at).local().format('MMMD, YYYY') }}</div> -->
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12">
            <div>Description: </div>
            <!-- <strong>{{ row.desc ? row.desc : 'N/A' }}</strong> -->
            <hr />
          </div>
          <div class="col-12">
            <div>Requirements: </div>
            <!-- <strong>{{ `${row.age_start} - ${row.age_end} Years Old` }}</strong> -->
            <hr class="mt-1" />
          </div>
          <div class="col-12">
            <!-- <div>Contract Price: <strong>{{ NumberAddComma(row.contract_price) }}</strong></div>
            <div>Spot Payment: <strong>{{ NumberAddComma(row.spot_pay) }}</strong></div>
            <div>Spot Service: <strong>{{ NumberAddComma(row.spot_service) }}</strong></div>
            <div>Annual: <strong>{{ NumberAddComma(row.contract_price / 5) }}</strong></div>
            <div>Semi-Annual: <strong>{{ NumberAddComma(row.contract_price / 10) }}</strong></div>
            <div>Quarterly: <strong>[12,089]</strong></div>
            <div>Monthly: <strong>[12,089]</strong></div> -->
          </div>

        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { useRoleStore } from '@/store/users/role';
import moment from 'moment';
import { NumberAddComma } from '@/helpers/converter'

const $role = useRoleStore();
</script>
