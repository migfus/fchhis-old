<template>
  <div class="row">
    <div class="col-12 col-md-6">

      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Transactions (Summary)</strong></h4>

          <!-- <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div> -->

        </div>
        <div class="card-body table-responsive">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Year</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Dec</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row, index in $dash.content.summaryTransaction">
                <td>{{ index }}</td>
                <td v-for="row2 in row.reverse()">{{ NumberAddComma(row2[1]) }}</td>
              </tr>
            </tbody>
          </table>

          <div>
            <button class="btn btn-info float-right mt-2">Print</button>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Beneficiaries</strong></h4>

          <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
                <button type="submit" class="btn btn-success">
                  Add
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Name</th>
                <th>Age</th>
                <th width="100">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in 5">
                <td>Juan De loslos</td>
                <td>12</td>
                <td>
                  <button class="btn btn-info btn-sm mr-1"><i class="fas fa-pen"></i></button>
                  <button class="btn btn-danger btn-sm px-2"><i class="fas fa-times"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><strong>Transactions</strong></h4>

          <!-- <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div> -->

        </div>
        <div class="card-body">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th width="100">OR</th>
                <th>Amount</th>
                <th width="100">Date</th>
                <th width="60">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in $dash.content.transactions">
                <td>{{ row.id }}</td>
                <td class="text-success text-bold">+{{ NumberAddComma(row.amount) }}</td>
                <td class="">{{ moment(row.created_at).format('MMM D, YYYY HH:mm:ss') }}</td>
                <td>
                  <button class="btn btn-warning btn-sm mr-1 float-right"><i class="fas fa-receipt"></i></button>
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            Total: <strong v-if="$dash.content.sumTransactions" class="text-success">
              {{ NumberAddComma($dash.content.sumTransactions) }}
            </strong>
          </div>
          <!-- <div>
            To Pay: <strong class="text-orange">78,000.00</strong>
          </div> -->

        </div>
      </div>
    </div>


  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useDashboardStore } from '@/store/system/dashboard'
import { NumberAddComma, } from '@/helpers/converter'
import moment from 'moment'

const $dash = useDashboardStore();
</script>
