<template>
    <div v-if="$user.content" class="row">
        <!-- {{ $user.content }} -->
        <div class="col-12 col-md-5">
            <ProfileCard />
            <BeneficiaryTable />
        </div>

        <div class="col-12 col-md-7">
            <TransactionCard />
        </div>

        <ClaimModal />
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { NumberAddComma, PlanToPay } from '@/helpers/converter'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
// import { useBeneficiaryStore } from '@/store/users/BeneficiaryStore'

import ClaimModal from './modals/ClaimModal.vue'
import BeneficiaryTable from './cards/BeneficiaryTable.vue'
import AddBeneficiary from './forms/AddBeneficiary.vue'
import TransactionCard from './cards/TransactionCard.vue'
import ProfileCard from './cards/ProfileCard.vue'

const $route = useRoute();
const $user = useUserDetailsStore();
// const $ben = useBeneficiaryStore();

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
