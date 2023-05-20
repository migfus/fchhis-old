<template>
  <div v-if="$user.content" class="col-12">


    <div v-for="(row, idx,) in $user.content.data" :class="`card mb-2 ${$user.config.viewAll ? '' : 'collapsed-card'}`">
      <div class="card-header" style="cursor: pointer;">
        <div data-card-widget="collapse" ref="collapse-click">
          <div class="row">
            <div class="col-12 col-md-6 col-xl-4">
              <span class="d-inline d-md-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>

              <img v-if="row.user.avatar" :src="row.user.avatar" style="height: 2em;" class="img-circle float-left mr-3">
              <VueAvatar v-else-if="row.user.username" :username="row.user.username" style="height: 1.5em; width: 1.5em"
                :alt="row.username" class="img-circle float-left mr-3" />
              <img v-else src="https://fchhis.migfus20.com/images/logo.png" style="height: 2em;"
                class="img-circle float-left mr-3">


              <BadgeComponent :role="row.user.role" />
              <div>
                <strong>
                  {{ row.name }}
                </strong>
              </div>
              <div><strong>{{ row.user.username }}</strong></div>
            </div>
            <div v-if="row.user.email" class="d-none d-md-inline col-md-6 col-xl-4">
              <span class="d-inline d-xl-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>
              <div>Email: <strong>{{ row.user.email }}</strong></div>
              <div>Role: <strong>{{ RoleToDesc(row.user.role) }}</strong></div>
            </div>
            <div v-else class="d-none d-md-inline col-md-6 col-xl-4">
              Link: <a :href="row.OR" target="_blank">{{ `https://fchhis.migfus20.com/register?or=${row.OR}` }}</a>
              <div class="text-danger">Unregistered</div>
            </div>
            <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
              <span class="float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div>Plan: <strong>{{ `${row.plan.name} (${row.pay_type.name})` }}</strong></div>
              <div>Total: <strong>{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <!-- <div>Agent: <strong>{{ row.agent.name }}</strong></div> -->
            <div>Plan: <strong>{{ `${row.plan.name} (${row.pay_type.name})` }}</strong></div>
            <div>Target: <strong class="text-danger">{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            <div>Accumulated:
              <strong class="text-success">{{ NumberAddComma(row.client_transactions_sum_amount) }}</strong>
            </div>
            <div>Username: <strong>{{ row.user.username }}</strong></div>

            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Email: <strong>{{ row.user.email }}</strong></div>
            <div>Name: <strong> {{ row.name }} </strong> </div>
            <div>Birth Day: <strong>{{ moment(row.bday).local().format('MMM D, YYYY') }}</strong></div>
            <div>Birth Place: <strong>{{ CityIDToFullAddress(row.bplace_id) }}</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">

            <div>Created On: <strong>{{ moment(row.created_at).local().format('MMM DD, YYYY h:mm A') }}</strong></div>
            <div>Staff: <strong>{{ row.staff.name }}</strong></div>
            <div>Role: <strong>{{ RoleToDesc(row.user.role) }}</strong></div>
            <div>Phone: <strong>[phone]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Province: <strong>{{ ProvinceIDToDesc(row.address_id) }}</strong></div>
            <div>City: <strong>{{ CityIDToDesc(row.address_id) }}</strong></div>
            <div>Address: <strong>{{ row.address }}</strong></div>
            <div>Sex: <strong>{{ row.sex ? 'Male' : 'Female' }}</strong></div>
            <hr class="mt-1" />
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button @click="$user.Delete(row.id, idx)" class="btn btn-danger btn-sm float-right">
              Remove
            </button>
            <button @click="$user.Update(row)" class="btn btn-warning btn-sm float-right mr-1">
              Edit
            </button>
            <button class="btn btn-secondary btn-sm float-right mr-1">
              Info
            </button>
          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import moment from "moment"
import { useUsersStore } from '@/store/users/UsersStore'
import { RoleToDesc } from '@/helpers/converter'
import BadgeComponent from '../components/BadgeComponent.vue'
import { CityIDToFullAddress, ProvinceIDToDesc, CityIDToDesc, NumberAddComma } from '@/helpers/converter'
import VueAvatar from "@webzlodimir/vue-avatar";
import "@webzlodimir/vue-avatar/dist/style.css";

const $user = useUsersStore();
</script>
