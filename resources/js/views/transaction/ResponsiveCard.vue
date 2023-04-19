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
              <div>Encoded By: <strong>
                  {{
                    FullNameConvert(row.staff.person.lastName, row.staff.person.firstName, row.staff.person.midName,
                      row.staff.person.extName)
                  }}
                </strong></div>
              <div>Refered: <strong>
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
            <div>Refered: <strong>[Juan Do do]</strong></div>
            <div>Plan: <strong>[bla]</strong></div>
            <div>Target: <strong>[bla]</strong></div>
            <div>Transact: <strong>[2,000]</strong></div>
            <div>Total: <strong>[12,089]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Username: <strong>[bla]</strong></div>
            <div>Email: <strong>[bla]</strong></div>
            <div>Name:
              <strong>
                [bla]
              </strong>
            </div>
            <div>Birth Day: <strong>[bla]</strong></div>
            <div>Birth Place: <strong>[bla]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">

            <div>Created On: <strong>[bla]</strong></div>
            <div>Encoded By: <strong>[bla]</strong></div>
            <div>Role: <strong>[bla]</strong></div>
            <div>Phone: <strong>[bla]</strong></div>
            <div>Last Active: <strong>[Sep 31, 2022]</strong></div>
            <hr class="mt-1" />
          </div>
          <div class="col-12 col-md-6 col-lg-4 col-xl-3">
            <div>Province: <strong>[bla]</strong></div>
            <div>City: <strong>[bla]</strong></div>
            <div>Address: <strong>[bla]</strong></div>
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
import { useTransactionStore } from '@/store/transaction/transaction'
import { NumberAddComma, FullNameConvert } from '@/helpers/converter'
import moment from 'moment'

const $trans = useTransactionStore();
</script>
