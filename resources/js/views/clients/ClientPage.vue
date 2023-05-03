<template>
  <div class="row">

    <EditForm v-if="$user.config.form == 'update'" />
    <ORForm v-else-if="$user.config.form == 'or'" />
    <AddForm v-else-if="$user.config.form" />

    <UserSummary />


    <SearchComponent />


    <MobileComponent />

    <!-- NOTE PAGINATION -->
    <PaginationComponent />

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { usePlanStore } from '@/store/system/plan'
import { useUserStore } from '@/store/users/users'
import { usePayTypeStore } from '@/store/system/payTypes'
import { useAgentStore } from '@/store/users/agent'

import UserSummary from './contents/UserSummary.vue'
import MobileComponent from './contents/MobileComponent.vue'
import SearchComponent from './search/SearchComponent.vue'
import PaginationComponent from './components/PaginationComponent.vue'
import AddForm from './forms/AddForm.vue'
import EditForm from './forms/EditForm.vue'
import ORForm from './forms/ORForm.vue'

const $plan = usePlanStore();
const $user = useUserStore();
const $payType = usePayTypeStore();
const $agent = useAgentStore();

onMounted(() => {
  $plan.GetAPI();
  $payType.GetAPI();
  $agent.GetAPI();
});
</script>
