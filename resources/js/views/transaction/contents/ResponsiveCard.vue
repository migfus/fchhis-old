<template>
  <div class="col-12">


    <div v-for="(row, idx,) in $trans.content.data" :class="`card mb-2 ${$trans.config.viewAll ? '' : 'collapsed-card'}`">
      <div class="card-header" style="cursor: pointer;">
        <div data-card-widget="collapse" ref="collapse-click">
          <div class="row">
            <div class="col-12 col-md-6 col-xl-4">
              <span class="d-inline d-md-none float-right text-secondary">
                {{ moment(row.created_at).format('MMM D YYYY') }}
              </span>

              <img :src="row.client.avatar" style="height: 2em;" class="img-circle float-left mr-3">

              <div>
                <strong>
                  {{
                    FullNameConvert(row.client.person.lastName, row.client.person.firstName, row.client.person.midName,
                      row.client.person.extName)
                  }}
                </strong>
              </div>
              <div>Amount: <strong class="text-success">+{{ NumberAddComma(row.amount) }}</strong></div>
            </div>
            <div class="d-none d-md-inline col-md-6 col-xl-4">
              <span class="d-inline d-xl-none float-right text-secondary">{{ moment(row.created_at).format('MMM D YYYY')
              }}</span>
              <div>Plan: <strong>{{ row.plan.name }}</strong></div>
              <div>Total: <strong class="">{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            </div>
            <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
              <span class="float-right text-secondary"> {{ moment(row.created_at).format('MMM D YYYY') }}
              </span>
              <div>Staff: <strong>
                  {{
                    FullNameConvert(row.staff.person.lastName, row.staff.person.firstName, row.staff.person.midName,
                      row.staff.person.extName)
                  }}
                </strong></div>
              <div>Agent: <strong>
                  {{
                    FullNameConvert(row.agent.person.lastName, row.agent.person.firstName, row.agent.person.midName,
                      row.agent.person.extName)
                  }}
                </strong></div>

            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row mb-2">
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Payment: <strong class="text-success">+{{ NumberAddComma(row.amount) }}</strong></div>
            <div>Accumulated: <strong>{{ NumberAddComma(100) }}</strong></div>
            <div>To Pay: <strong>1,000</strong></div>
            <hr class="mt-1" />


          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Payed By: <strong class="text-success">{{ FullNameConvert(row.client.person.lastName,
              row.client.person.firstName,
              row.client.person.midName, row.client.person.extName) }}</strong></div>
            <div>Username: <strong>{{ row.client.username }}</strong></div>
            <div>Email: <strong>{{ row.client.email }}</strong></div>
            <hr class="mt-1" />


          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Staff:
              <strong class="text-info">
                {{
                  FullNameConvert(
                    row.staff.person.lastName,
                    row.staff.person.firstName,
                    row.staff.person.midName,
                    row.staff.person.extName
                  )
                }}
              </strong>
            </div>
            <div>Agent:
              <strong class="text-warning">
                {{
                  FullNameConvert(
                    row.agent.person.lastName,
                    row.agent.person.firstName,
                    row.agent.person.midName,
                    row.agent.person.extName
                  )
                }}
              </strong>
            </div>
            <div>Referal ID: <strong> {{ row.agent.id }} </strong> </div>
            <!-- <div>Birth Day: <strong>[bla]</strong></div>
            <div>Birth Place: <strong>[bla]</strong></div> -->
            <hr class="mt-1" />

          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Province: <strong>{{ NumberAddComma(row.plan.name) }}</strong></div>
            <div>Spot Payment: <strong>{{ NumberAddComma(row.plan.spot_pay) }}</strong></div>
            <div>Spot Service: <strong>{{ NumberAddComma(row.plan.spot_service) }}</strong></div>
            <!-- <div>Contract Price: <strong>{{ NumberAddComma(row.plan.contract_price) }}</strong></div> -->
            <hr class="mt-1" />
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
            <div v-if="$auth.auth.id != row.staff_id" class="alert alert-light mb-0 p-0 px-2" role="alert">
              Accessable only by:
              <strong>
                {{
                  FullNameConvert(
                    row.staff.person.lastName,
                    row.staff.person.firstName,
                    row.staff.person.midName,
                    row.staff.person.extName
                  )
                }}
              </strong>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <button v-if="$auth.auth.role == 2" @click="$trans.Delete(row.id, idx)"
              class="btn btn-danger btn-sm float-right">
              Remove
            </button>

            <button v-if="$auth.auth.id == row.staff_id" @click="$trans.Update(row)"
              class="btn btn-warning btn-sm float-right mr-1">
              Edit
            </button>
            <button v-else class="btn btn-warning btn-sm float-right mr-1" Disabled>
              You can't edit
            </button>

            <button class="btn btn-info btn-sm float-right mr-1">
              Print
            </button>


          </div>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { useTransactionStore } from '@/store/transaction/transaction'
import { NumberAddComma, FullNameConvert } from '@/helpers/converter'
import moment from 'moment'
import { useAuthStore } from '@/store/auth/auth'

const $trans = useTransactionStore();
const $auth = useAuthStore();
</script>
