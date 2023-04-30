<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><strong>Transactions (Summary)</strong></h4>

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
        <button class="btn btn-success btn-sm float-right mt-2"><i class="fas fa-print mr-2"></i>Print</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useDashboardStore } from '@/store/dashboard/dashboard'
import { NumberAddComma } from '@/helpers/converter'

const $dash = useDashboardStore();
</script>

