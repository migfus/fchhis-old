<template>
  <SummaryCards />

  <div class="row">
    <ClientsCard v-if="$ben.content" />
    <TransactionsCard v-if="$trans.content" />
  </div>
</template>

<script setup>
import { useTransactionStore } from '@/store/transaction/transaction'
import { useBeneficiaryStore } from '@/store/dashboard/beneficiary'

import SummaryCards from './SummaryCards.vue';
import ClientsCard from './ClientsCard.vue'
import TransactionsCard from './TransactionsCard.vue'

const $trans = useTransactionStore();
const $ben = useBeneficiaryStore();

</script>
