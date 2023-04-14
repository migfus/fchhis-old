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

          <div class="col-12 col-md-4 mb-2">

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-check"></i></span>
              </div>
              <select v-model="$user.params.role" class="form-control">
                <option :value="7">All (Role)</option>
                <option :value="2">Admin</option>
                <option :value="3">Manager</option>
                <option :value="4">Agent</option>
                <option :value="5">Staff</option>
                <option :value="6">Client</option>
                <option :value="0">Inactive</option>
                <option :value="1">Banned</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
              </div>
              <select v-model="$user.params.filter" class="form-control">
                <option value="">All (Filter)</option>
                <option value="name">Name</option>
                <option value="email">Email</option>
                <option value="address">Address</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4">
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
        </div>

        <div class="row mt-2">
          <div class="col-12 col-md-4 mb-2">
            <VueDatePicker v-model="$user.params.start" :start-date="moment().startOf('month').format('YYYY-MM-DD')"
              :enable-time-picker="false" auto-apply placeholder="Start Date" />
          </div>
          <div class="col-12 col-md-4 mb-2">
            <VueDatePicker v-model="$user.params.end" :start-date="moment().endOf('month').format('YYYY-MM-DD')"
              :enable-time-picker="false" auto-apply placeholder="End Date" />
          </div>

          <div class="col-12 col-md-4">
            <button v-if="$user.config.form" @click="$user.ChangeForm('')" class="btn btn-danger float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Cancel</span>
            </button>
            <button v-else @click="$user.ChangeForm('add')" class="btn btn-success float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Add User</span>
            </button>

            <button @click="$user.config.tableView = !$user.config.tableView" class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$user.config.tableView ? 'fa-bars' : 'fa-table'}`"></i>
            </button>
            <button @click="$user.config.viewAll = !$user.config.viewAll" :disabled="$user.config.tableView"
              class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$user.config.viewAll ? 'fa-window-minimize' : 'fa-window-maximize'}`"></i>
            </button>
            <button class="btn btn-info mr-1 float-right">
              <i class="fas fa-print"></i>
            </button>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, onMounted } from 'vue'
import { useUserStore } from '@/store/users'
import moment from 'moment'
import { throttle } from 'lodash'

import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const $user = useUserStore();

watch($user.params, throttle(() => {
  $user.GetAPI(1)
}, 1000))

onMounted(() => {
  $user.GetAPI()
});
</script>
