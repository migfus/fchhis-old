<template>
  <div class="card">
    <div class="card-header border-0">
      <h3 class="card-title"><strong>Top Agent</strong></h3>
      <div class="card-tools">
        <a href="#" class="btn btn-tool btn-sm">
          <i class="fas fa-bars"></i>
        </a>
      </div>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table table-striped table-valign-middle">
        <thead>
          <tr>
            <th>Name</th>
            <th>Transactions</th>
            <!-- <th>More</th> -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in $stat.content.topPerformer" :key="row.username">
            <td>
              <img :src="row.avatar || 'https://fchhis.migfus20.com/images/logo.png'" alt="Product 1"
                class="img-circle img-size-32 mr-2">
              {{ row.name }}
            </td>
            <td>
              +{{ NumberAddComma(row.total) }}
            </td>
            <!-- <td>
              <RouterLink :to="`/user/${row.id}`" class="text-muted">
                <i class="fas fa-search"></i>
              </RouterLink>
            </td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { useStatisticStore } from '@/store/dashboard/StatisticStore';
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'

const $stat = useStatisticStore();
</script>
