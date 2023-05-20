<template>
  <SummaryCards />

  <div class="row">
    <ClientsCard />
    <!-- <TransactionsCard v-if="$trans.content" /> -->
  </div>
</template>

<script setup>
import SummaryCards from './SummaryCards.vue';
import ClientsCard from './ClientsCard.vue'
// import TransactionsCard from './TransactionsCard.vue'
</script>
