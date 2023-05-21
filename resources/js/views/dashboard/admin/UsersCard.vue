<template>
  <div class="col-12">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><i class="fas fa-users mr-2"></i>{{ $stat.content.usersCount }}</h3>
        <p>Users</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</template>

<script setup>
import { useStatisticStore } from '@/store/dashboard/StatisticStore';
import { NumberAddComma } from '@/helpers/converter'

const $stat = useStatisticStore();
</script>
