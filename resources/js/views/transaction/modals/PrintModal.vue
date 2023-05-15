<template>
  <div>
    <div class="modal fade" id="modal-print">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Select Date</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="col-12 mb-2">
                <strong>Select Date Range to Print</strong>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-6 mb-2">
                <VueDatePicker v-model="$trans.query.start" :enable-time-picker="false"
                  :start-date="moment().startOf('month').format('YYYY-MM-DD')" placeholder="Start Date" auto-apply />
              </div>
              <div class="col-12 col-md-6 mb-2">
                <VueDatePicker v-model="$trans.query.end" :enable-time-picker="false"
                  :start-date="moment().endOf('month').format('YYYY-MM-DD')" placeholder="End Date" auto-apply />
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <button @click="Print()" :disabled="disabledPrint" data-dismiss="modal" aria-label="Close"
                  class="btn btn-info float-right">Print</button>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</template>

<script setup>
import { useTransactionStore } from '@/store/transaction/transaction';
import moment from 'moment'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { computed } from 'vue'
import { useTransactionStaff } from '@/store/print/transactionStaff'
import { useProfileStore } from '@/store/auth/profile'
import { FullNameConvert } from '@/helpers/converter'

const $trans = useTransactionStore();
const $report = useTransactionStaff();
const $profile = useProfileStore();

const disabledPrint = computed(() => {
  if ($trans.query.start && $trans.query.end) {
    return false
  }
  return true
})

async function Print() {
  $trans.query.print = true
  await $trans.PrintAPI()
  await $profile.GetAPI()

  $report.Print({
    header: {
      name: FullNameConvert($profile.content.person.lastName, $profile.content.person.firstName, $profile.content.person.midName, $profile.content.person.extName),
      start: moment($trans.query.start).format("MMM D, YYYY"),
      end: moment($trans.query.end).format("MMM D, YYYY"),
    },
    body: $trans.printContent.map(m => { return { plan: m.plan.name, type: m.pay_type.name, amount: m.amount, date: moment(m.created_at).format('MM/DD/YYYY HH:MM A') } }),
  })

  $trans.query.print = false
}
</script>
