<template>
  <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="fas fa-child"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Clients</span>
          <span class="info-box-number">{{ $dash.content.counts.clients }}</span>
        </div>

      </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-info"><i class="fas fa-receipt"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Transactions</span>
          <span class="info-box-number">{{ $dash.content.counts.transactions }}</span>
        </div>

      </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span v-if="$dash.content.counts.current > 0" class="info-box-icon bg-success">
          <i class="fas fa-arrow-up"></i>
        </span>
        <span v-else class="info-box-icon bg-danger">
          <i class="fas fa-arrow-down"></i>
        </span>
        <div class="info-box-content">
          <span class="info-box-text">Current Month</span>
          <span class="info-box-number">{{ $dash.content.counts.current }} %</span>
        </div>

      </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-secondary"><i class="fas fa-moon"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Inactive</span>
          <span class="info-box-number">{{ $dash.content.counts.inactive }}</span>
        </div>

      </div>

    </div>

  </div>
</template>

<script setup>
import { useDashboardStore } from '@/store/dashboard/dashboard'

const $dash = useDashboardStore();
</script>
