<template>
  <div class="row">
    <div class="col-lg-6 col-6">

      <div v-if="$dash.content.usersCount" class="small-box bg-info">
        <div class="inner">
          <h3><i class="fas fa-users mr-2"></i>{{ $dash.content.usersCount }}</h3>
          <p>Users</p>
        </div>
        <div class="icon">
          <i class="fas fa-users"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>

      <div v-else class="small-box card-loader">
        <div class="inner">
          <h3 class="card-loader-content mw-1">&nbsp;</h3>
          <p class="card-loader-contnet">&nbsp;</p>
        </div>
        <div class="icon">
          <i class="fas fa-refresh"></i>
        </div>
      </div>

    </div>

    <div class="col-lg-6 col-6">

      <div v-if="$dash.content.transactionCount" class="small-box bg-success">
        <div class="inner">
          <h3>₱ {{ $dash.content.transactionCount }} </h3>
          <p>Monthly Income</p>
        </div>
        <div class="icon">
          <i class="fas fa-chart-line"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>


  </div>
</template>

<script setup>
import { useDashboardStore } from '@/store/system/dashboard';

const $dash = useDashboardStore();
</script>
