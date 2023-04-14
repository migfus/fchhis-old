<template>
  <div class="col-12">

    <div v-for="(row, idx,) in $user.list.data" :class="`card mb-2 ${$user.config.viewAll ? '' : 'collapsed-card'}`">
      <div class="card-header" style="cursor: pointer;">
        <div data-card-widget="collapse" ref="collapse-click">
          <div class="row">
            <div class="col-12 col-md-6 col-xl-4">
              <span class="d-inline d-md-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>
              <img :src="row.avatar" style="height: 2em;" class="img-circle float-left mr-3">
              <BadgeComponent :role="row.role" />
              <div>
                <strong>
                  {{ FullNameConvert(row.person.lastName, row.person.firstName, row.person.midName, row.extName) }}
                </strong>
              </div>
              <div><strong>{{ row.username }}</strong></div>
            </div>
            <div class="d-none d-md-inline col-md-6 col-xl-4">
              <span class="d-inline d-xl-none float-right text-secondary"> {{
                moment(row.created_at).local().format('MMMD, YYYY') }} </span>
              <div>Email: <strong>{{ row.email }}</strong></div>
              <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
            </div>
            <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
              <span class="float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }}
              </span>
              <div>Plan: <strong>[Jade]</strong></div>
              <div>Total: <strong>[12,000]</strong></div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Refered: <strong>[Juan Do do]</strong></div>
            <div>Plan: <strong>[Jade]</strong></div>
            <div>Transact: <strong>[1,000]</strong></div>
            <div>Accumulated: <strong>[2,000]</strong></div>
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
            <div>Birth Place: <strong>{{ row.person.bplace_id }}</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">

            <div>Created On: <strong>{{ moment(row.created_at).local().format('MMM DD, YYYY h:mm A') }}</strong></div>
            <div>Encoded By: <strong>[Juan De Loslos]</strong></div>
            <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
            <div>Phone: <strong>{{ row.phone }}</strong></div>
            <div>Last Active: <strong>[Sep 31, 2022]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Province: <strong>{{ row.person.address_id }}</strong></div>
            <div>City: <strong>{{ row.person.address_id }}</strong></div>
            <div>Address: <strong>{{ row.person.address }}</strong></div>
            <div>Sex: <strong>Male</strong></div>
            <div>Address: <strong>123 St. Roxina Taboboy</strong></div>
            <hr class="mt-1" />
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button @click="$user.Delete(row.id, idx)" class="btn btn-danger btn-sm float-right">
              Remove
            </button>
            <button @click="$user.Update()" class="btn btn-secondary btn-sm float-right mr-1">
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
import { useUserStore } from '@/store/users'
import { RoleToDesc } from '@/helpers/converter'
import BadgeComponent from './BadgeComponent.vue'
import { FullNameConvert } from '@/helpers/converter'

const $user = useUserStore();
</script>
