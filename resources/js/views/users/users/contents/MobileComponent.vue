<template>
  <div class="col-12">


    <div v-for="(row, idx,) in $user.list.data" :class="`card mb-2 ${$user.config.viewAll ? '' : 'collapsed-card'}`">
      <div class="card-header" style="cursor: pointer;">
        <div data-card-widget="collapse" ref="collapse-click">
          <div class="row">
            <div class="col-12 col-md-6 col-xl-4">
              <span class="d-inline d-md-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>

              <img v-if="row.avatar" :src="row.avatar" style="height: 2em;" class="img-circle float-left mr-3">
              <VueAvatar v-else-if="row.username" :username="row.username" style="height: 1.5em; width: 1.5em"
                :alt="row.username" class="img-circle float-left mr-3" />
              <img v-else src="/images/logo.png" style="height: 2em;" class="img-circle float-left mr-3">


              <BadgeComponent :role="row.role" />
              <div>
                <strong>
                  {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.extName) }}
                </strong>
              </div>
              <div><strong>{{ row.username }}</strong></div>
            </div>
            <div v-if="row.email" class="d-none d-md-inline col-md-6 col-xl-4">
              <span class="d-inline d-xl-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>
              <div>Email: <strong>{{ row.email }}</strong></div>
              <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
            </div>
            <div v-else class="d-none d-md-inline col-md-6 col-xl-4">
              Link: <a :href="row.OR" target="_blank">{{ `http://127.0.0.1:8000/register?or=${row.OR}` }}</a>
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
            <div>Refered: <strong>{{ FullNameConvert(row.person.referred.person.lastName,
              row.person.referred.person.firstName, row.person.referred.person.midName,
              row.person.referred.person.extName) }}</strong></div>
            <div>Plan: <strong>{{ `${row.plan.name} (${row.pay_type.name})` }}</strong></div>
            <div>Target: <strong>{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            <div>Transact: <strong>[2,000]</strong></div>
            <div>Total: <strong>[12,089]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Username: <strong>{{ row.username }}</strong></div>
            <div>Email: <strong>{{ row.email }}</strong></div>
            <div>Name:
              <strong>
                {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.extName) }}
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
            <div>Phone: <strong>{{ row.phone }}</strong></div>
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
import { useUserStore } from '@/store/users/users'
import { RoleToDesc } from '@/helpers/converter'
import BadgeComponent from '../components/BadgeComponent.vue'
import { FullNameConvert } from '@/helpers/converter'
import { CityIDToFullAddress, ProvinceIDToDesc, CityIDToDesc } from '@/helpers/converter'
import VueAvatar from "@webzlodimir/vue-avatar";
import "@webzlodimir/vue-avatar/dist/style.css";
import { NumberAddComma } from '@/helpers/converter';

const $user = useUserStore();
</script>
