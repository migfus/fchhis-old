<template>
  <div v-if="$user.content.user" class="row" :style="`background-image: url(${dead})`">
    <div class="col-12 col-md-5">
      <ProfileCard />
      <TransactionAgentTable v-if="$user.content.user.role == 4" />
      <BeneficiaryTable v-else />
    </div>

    <div class="col-12 col-md-7">
      <ClientTable v-if="$user.content.user.role == 4" />
      <TransactionTable v-else />
    </div>

    <ClaimModal />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { NumberAddComma, PlanToPay } from '@/helpers/converter'
import { useUserDetailsStore } from '@/store/user/UserDetailStore'
import { useBeneficiaryStore } from '@/store/users/BeneficiaryStore'

import ClaimModal from './ClaimModal.vue'
import TransactionTable from './TransactionTable.vue'
import BeneficiaryTable from './BeneficiaryTable.vue'
import AddBeneficiary from './forms/AddBeneficiary.vue'
import ClientTable from './ClientTable.vue'
import ProfileCard from './ProfileCard.vue'
import TransactionAgentTable from './TransactionAgentTable.vue'

const $route = useRoute();
const $user = useUserDetailsStore();
const $ben = useBeneficiaryStore();

onMounted(() => {
  $user.GetAPI($route.params.id)
});
// onUnmounted(() => {
//   $user.params.id = null
// });
</script>

<style scoped>
.ribbon-wrapper {
  left: 0 !important;
  transform: rotate(270deg)
}
</style>
