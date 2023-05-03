<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">

          <div v-if="$user.config.notify" class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Notify</strong> We don't recommend to delete some records, it will reflect everything that they
              transact.
              <button @click="$user.RemoveNotify" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>

          <div class="col-12 col-md-3 mb-2">
            <div class="row">
              <div class="col-6">
                <VueDatePicker v-model="$user.params.start" :enable-time-picker="false"
                  :start-date="moment().startOf('month').format('YYYY-MM-DD')" placeholder="Start Date" auto-apply />
              </div>
              <div class="col-6">
                <VueDatePicker v-model="$user.params.end" :enable-time-picker="false"
                  :start-date="moment().endOf('month').format('YYYY-MM-DD')" placeholder="End Date" auto-apply />
              </div>
            </div>
          </div>


          <div class="col-12 col-md-3 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
              </div>
              <select v-model="$user.params.filter" class="form-control">
                <!-- <option value="">All (Filter)</option> -->
                <option value="name">Name</option>
                <option value="email">Email</option>
                <option value="address">Address</option>
                <option value="plans">Plans</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-3 mb-2">
            <div class="input-group input-group float-right">
              <input v-model="$user.params.search" type="text" name="table_search" class="form-control float-right"
                placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i :class="`fas ${$user.config.loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="col-12 col-md-3">
            <button v-if="$user.config.form" @click="$user.ChangeForm('')" class="btn btn-danger float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Cancel</span>
            </button>
            <button v-else @click="$user.ChangeForm('add')" class="btn btn-success float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Add User</span>
            </button>
            <button v-if="$user.config.form == ''" @click="$user.ChangeForm('or')" class="btn btn-info float-right mr-1">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Add OR</span>
            </button>

            <button v-if="$user.config.loading" class="btn card-loader-content card-loader mr-1 float-right"
              style="width: 42px">
              &nbsp;
            </button>
            <button v-else @click="Print()" class="btn btn-info mr-1 float-right">
              <i class="fas fa-print"></i>
            </button>

          </div>
        </div>



      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, watch, onMounted } from 'vue'
import { useUserStore } from '@/store/users/users'
import moment from 'moment'
import { throttle } from 'lodash'
import { userReportStore } from '@/store/print/userReport'
import { useProfileStore } from '@/store/auth/profile'
import { FullNameConvert } from '@/helpers/converter'

import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const $user = useUserStore();
const $print = userReportStore();
const $profile = useProfileStore();

const printTitle = computed(() => {
  if ($user.params.start || $user.params.end) {
    return `${moment($user.params.start || moment($user.params.end).subtract(1, 'months')).format('MMM D, YYYY')} - ${moment($user.params.end || moment($user.params.start).add(1, 'months')).format('MMM D, YYYY')}`
  }
  else {
    return 'All Time'
  }
})

function Print() {
  $print.Print({
    header: {
      title: printTitle.value,
      name: FullNameConvert($profile.content.person.lastName, $profile.content.person.firstName, $profile.content.person.midName, $profile.content.person.extName)
    },
    body: [10].map(m => { return { plan: '', type: '', amount: '', date: '' } }),
  })
}

watch($user.params, throttle(() => {
  $user.GetAPI(1)
}, 1000))

onMounted(() => {
  $user.GetAPI()
  $profile.GetAPI()
});
</script>
