<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="row">

          <div v-if="$trans.config.notify" class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>Notify</strong> We don't recommend to delete some records, it will reflect everything that they
              transact.
              <button @click="$trans.NotifyToggle" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>

          <div class="col-12 col-md-4 mb-2">

            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-check"></i></span>
              </div>
              <select v-model="$trans.params.target" class="form-control">
                <option :value="6">Client (Target)</option>
                <option :value="5">Staff</option>
                <option :value="4">Agent</option>
              </select>
            </div>
          </div>

          <div class="col-12 col-md-4 mb-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-filter"></i></span>
              </div>
              <select v-model="$trans.params.filter" class="form-control">
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
              <input v-model="$trans.params.search" type="text" name="table_search" class="form-control float-right"
                placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i :class="`fas ${$trans.config.loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-12 col-md-4 mb-2">
            <VueDatePicker v-model="$trans.params.start" :enable-time-picker="false"
              :start-date="moment().startOf('month').format('YYYY-MM-DD')" placeholder="Start Date" auto-apply />
          </div>
          <div class="col-12 col-md-4 mb-2">
            <VueDatePicker v-model="$trans.params.end" :enable-time-picker="false"
              :start-date="moment().endOf('month').format('YYYY-MM-DD')" placeholder="End Date" auto-apply />
          </div>

          <div class="col-12 col-md-4">
            <button v-if="$trans.config.form" @click="$trans.ChangeForm('')" class="btn btn-danger float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Cancel</span>
            </button>
            <button v-else @click="$trans.ChangeForm('add')" class="btn btn-success float-right">
              <i class="fas fa-plus-square d-inline d-xl-none"></i>
              <span class="d-none d-xl-inline">Add Transact</span>
            </button>

            <button @click="$trans.config.tableView = !$trans.config.tableView" class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$trans.config.tableView ? 'fa-bars' : 'fa-table'}`"></i>
            </button>
            <button @click="$trans.config.viewAll = !$trans.config.viewAll" :disabled="$trans.config.tableView"
              class="btn btn-info mr-1 float-right">
              <i :class="`fas ${$trans.config.viewAll ? 'fa-window-minimize' : 'fa-window-maximize'}`"></i>
            </button>

            <button v-if="$trans.config.loading" class="btn card-loader-content card-loader mr-1 float-right"
              style="width: 42px">
              &nbsp;
            </button>
            <button v-else class="btn btn-info mr-1 float-right">
              <i class="fas fa-print"></i>
            </button>

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { watch } from 'vue'
import { useTransactionStore } from '@/store/transaction/transaction'
import moment from 'moment'
import { throttle } from 'lodash'

import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

const $trans = useTransactionStore();

watch($trans.params, throttle(() => {
  $trans.GetAPI(1)
}, 1000));
</script>
