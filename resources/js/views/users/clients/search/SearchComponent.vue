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

          <div class="col-12 col-md-2 mb-2">
            <VueDatePicker v-model="$user.query.start" :enable-time-picker="false"
              :start-date="moment().startOf('month').format('YYYY-MM-DD')" placeholder="Start Date" auto-apply />
          </div>
          <div class="col-12 col-md-2 mb-2">
            <VueDatePicker v-model="$user.query.end" :enable-time-picker="false"
              :start-date="moment().endOf('month').format('YYYY-MM-DD')" placeholder="End Date" auto-apply />
          </div>

          <div class="col-12 col-md-4 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
              </div>
              <select v-model="$user.query.filter" class="form-control">
                <!-- <option value="">All (Filter)</option> -->
                <option value="name">Name</option>
                <option value="email">Email</option>
                <option value="address">Address</option>
                <option value="plans">Plans</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4">
            <div class="input-group input-group float-right">
              <input v-model="$user.query.search" type="text" name="table_search" class="form-control float-right"
                placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i :class="`fas ${$user.config.loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-12">
            <button v-if="$user.config.form" @click="$user.ChangeForm('')" class="btn btn-danger float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Cancel</span>
            </button>
            <button v-else @click="$user.ChangeForm('add')" class="btn btn-success float-right">
              <span class=""><i class="fas fa-plus mr-1"></i>Add User</span>
            </button>
            <button @click="$user.ChangeForm('or')" class="btn btn-info float-right mr-1">
              <span class=""><i class="fas fa-plus mr-1"></i>Self Register</span>
            </button>

            <!-- <button @click="$user.config.tableView = !$user.config.tableView" class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$user.config.tableView ? 'fa-bars' : 'fa-table'}`"></i>
            </button>
            <button @click="$user.config.viewAll = !$user.config.viewAll" :disabled="$user.config.tableView"
              class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$user.config.viewAll ? 'fa-window-minimize' : 'fa-window-maximize'}`"></i>
            </button> -->

            <button v-if="$user.config.loading" class="btn card-loader-content card-loader mr-1 float-right"
              style="width: 42px">
              &nbsp;
            </button>
            <button v-else class="btn btn-info mr-1 float-right">
              <i class="fas fa-print mr-1"></i>Print
            </button>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, onMounted } from 'vue'
import { useUsersStore } from '@/store/users/UsersStore'
import moment from 'moment'
import { throttle } from 'lodash'

import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const $user = useUsersStore();

watch($user.query, throttle(() => {
  $user.GetAPI(1)
}, 1000))

onMounted(() => {
  $user.query.sort = 'DESC'
  $user.query.limit = 10
  $user.query.role = 6
  $user.GetAPI()
});

// onUnmounted(() => {
//   $user.content = []
// });
</script>
