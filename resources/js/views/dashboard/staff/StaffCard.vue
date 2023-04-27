<template>
  <div>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Clients</span>
            <span class="info-box-number">{{ $dash.content.total }}</span>
          </div>

        </div>

      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-success"><i class="fas fa-child"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Created Clients</span>
            <span class="info-box-number">{{ $dash.content.clients }}</span>
          </div>

        </div>

      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-warning"><i class="fas fa-receipt"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Transactions</span>
            <span class="info-box-number">13,648</span>
          </div>

        </div>

      </div>

      <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
          <span class="info-box-icon bg-secondary"><i class="fas fa-moon"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Inactive Clients</span>
            <span class="info-box-number">{{ $dash.content.inactive }}</span>
          </div>

        </div>

      </div>

    </div>

    <ClientsCard />
  </div>
</template>

<script setup>
import { useDashboardStore } from '@/store/system/dashboard'

import ClientsCard from './ClientsCard.vue';

const $dash = useDashboardStore();
</script>
