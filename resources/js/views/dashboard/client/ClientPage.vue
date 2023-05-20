<template>
  <div class="row">
    <div class="col-12 col-md-6">
      <SummaryTransaction />
      <BeneficiaryCard />
    </div>

    <div class="col-12 col-md-6">
      <TransactionsCard />
    </div>
  </div>
</template>

<script setup>
import BeneficiaryCard from './cards/BeneficiariesCard.vue'
import TransactionsCard from './cards/TransactionsCard.vue'
import SummaryTransaction from './cards/SummaryTransaction.vue'
</script>
