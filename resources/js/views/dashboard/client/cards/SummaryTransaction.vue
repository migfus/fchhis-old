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
          <tr v-for="row, index in $stat.content">
            <td>{{ index }}</td>
            <td v-for="row2 in row.slice().reverse()">{{ NumberAddComma(row2[1]) }}</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</template>

<script setup>
import { useStatisticStore } from '@/store/dashboard/StatisticStore';
import { NumberAddComma } from '@/helpers/converter'
import { onMounted, onUnmounted } from 'vue'

const $stat = useStatisticStore();

onMounted(() => {
  $stat.GetAPI()
});

onUnmounted(() => {
  $stat.content = []
});
</script>

