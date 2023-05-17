<template>
  <div class="col-12">


    <div v-for="(row, idx,) in $user.list.data" :class="`card mb-2 ${$user.config.viewAll ? '' : 'collapsed-card'}`">
      <div class="card-header" style="cursor: pointer;">
        <div data-card-widget="collapse" ref="collapse-click">
          <div class="row">
            <div class="col-12 col-md-6 col-xl-4">
              <span class="d-inline d-md-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>

              <img v-if="row.avatar" :src="row.avatar" style="height: 3em;" class="img-circle float-left mr-3 mt-2">
              <VueAvatar v-else-if="row.username" :username="row.username" style="height: 1.5em; width: 1.5em"
                :alt="row.username" class="img-circle float-left mr-3" />
              <img v-else src="https://fchhis.migfus20.com/images/logo.png" style="height: 2em;"
                class="img-circle float-left mr-3">


              <BadgeComponent :role="row.role" />
              <div>
                <strong>
                  {{ FullNameConvert(row.person) }}
                </strong>
              </div>
              <div>{{ row.email }}</div>
              <div>{{ RoleToDesc(row.role) }}</div>
            </div>

            <div class="d-none d-md-inline col-md-6 col-xl-4">
              <div>Plan: <strong>{{ `${row.plan.name} (${row.pay_type.name})` }}</strong></div>
              <div>Total To Pay: <strong>{{ NumberAddComma(PlanToPay(row.pay_type, row.plan)) }}</strong></div>
              <div>Est. Bal. Due:
                <strong class="text-danger">
                  {{ NumberAddComma(PlanToPay(row.pay_type, row.plan) - row.client_transactions_sum_amount) }}
                </strong>
              </div>
            </div>
            <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
              <span class="float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div>Agent:
                <strong>
                  {{ FullNameConvert(row.person.agent.person) }}
                </strong>
              </div>
              <div>Staff:
                <strong>
                  {{ FullNameConvert(row.person.agent.person) }}
                </strong>
              </div>
              <div>Phone: <strong>{{ `${row.person.mobile}` }}</strong></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Refered: <strong>{{ FullNameConvert(row.person.referred.person) }}</strong></div>
            <div>Plan: <strong>{{ `${row.plan.name} (${row.pay_type.name})` }}</strong></div>
            <div>Target: <strong>{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            <div>Total Transact: <strong>{{ NumberAddComma(row.client_transactions_sum_amount) }}</strong></div>
            <div>Total Payment: <strong>[12,089]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Username: <strong>{{ row.username }}</strong></div>
            <div>Email: <strong>{{ row.email }}</strong></div>
            <div>Name:
              <strong>
                {{ FullNameConvert(row.person) }}
              </strong>
            </div>
            <div>Birth Day: <strong>{{ moment(row.person.bday).local().format('MMM D, YYYY') }}</strong></div>
            <div>Birth Place: <strong>{{ CityIDToFullAddress(row.person.bplace_id) }}</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">

            <div>Created On: <strong>{{ moment(row.created_at).local().format('MMM DD, YYYY h:mm A') }}</strong></div>
            <div>Encoded By: <strong>{{ row.person.user.username }}</strong></div>
            <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
            <div>Phone: <strong>{{ row.person.mobile }}</strong></div>
            <div>Last Active: <strong>[Sep 31, 2022]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Province: <strong>{{ ProvinceIDToDesc(row.person.address_id) }}</strong></div>
            <div>City: <strong>{{ CityIDToDesc(row.person.address_id) }}</strong></div>
            <div>Address: <strong>{{ row.person.address }}</strong></div>
            <div>Sex: <strong>Male</strong></div>
            <hr class="mt-1" />
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button @click="$user.Update(row)" class="btn btn-warning float-right mr-1">
              <i class="fas fa-edit"></i>
              Edit
            </button>
            <RouterLink :to="`/user/${row.id}`" class="btn btn-success float-right mr-1">
              <i class="fas fa-info-circle mr-1"></i> Info
            </RouterLink>
            <button @click="Print(row)" class="btn btn-info float-right mr-1">
              <i class="fas fa-print mr-1"></i> Print
            </button>
          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import moment from "moment"
import { useUserStore } from '@/store/users/users'
import { RoleToDesc } from '@/helpers/converter'
import BadgeComponent from '../components/BadgeComponent.vue'
import {
  CityIDToFullAddress,
  ProvinceIDToDesc,
  CityIDToDesc,
  NumberAddComma,
  FullNameConvert,
  PlanToPay,
} from '@/helpers/converter'
import VueAvatar from "@webzlodimir/vue-avatar";
import "@webzlodimir/vue-avatar/dist/style.css";
import { userDetailStore } from '@/store/print/userDetails'

const $user = useUserStore();
const $details = userDetailStore();

function Print(row) {
  $details.Print({
    header: {
      title: 'Client Details',
      name: FullNameConvert(row.person),
      created_at: moment(row.created_at).format('MM/DD/YYYY'),
      username: row.username,
      bday: moment(row.person.bday).format('MM/DD/YYYY'),
      bplace: CityIDToFullAddress(row.person.bplace_id),
      sex: row.person.sex ? 'Male' : 'Female',
      address: `${row.person.address}, ${CityIDToFullAddress(row.person.address_id)}`,
      email: row.email,
      mobile: row.person.mobile,
    },
    body: row.client_transactions.map(m => {
      return {
        name: m.plan.name,
        type: m.pay_type.name,
        amount: m.amount,
        created: moment(m.created_at).format("MM/DD/YYYY"),
      }
    }),
  })
}
</script>
