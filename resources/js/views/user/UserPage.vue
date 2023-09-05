<template>
    <div v-if="$user.content" class="row">
        <!-- {{ $user.content }} -->
        <div class="col-12 col-md-5">
            <ProfileCard />
            <BeneficiaryTable />
        </div>

        <div class="col-12 col-md-7">
            <InformationCard />
            <TransactionCard />
        </div>

        <ClaimModal />
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'

import ClaimModal from './modals/ClaimModal.vue'
import BeneficiaryTable from './cards/BeneficiaryTable.vue'
import TransactionCard from './cards/TransactionCard.vue'
import ProfileCard from './cards/ProfileCard.vue'
import InformationCard from './cards/InformationCard.vue'

const $route = useRoute();
const $user = useUserDetailsStore();

onMounted(() => {
    $user.GetAPI($route.params.id)
});
</script>

<style scoped>
.ribbon-wrapper {
    left: 0 !important;
    transform: rotate(270deg)
}
</style>
