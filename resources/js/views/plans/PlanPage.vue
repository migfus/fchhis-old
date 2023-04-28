<template>
  <div class="row">
    <AddForm v-if="$plan.config.form == 'add'" />
    <EditForm v-if="$plan.config.form == 'update'" />
    <PlanRanking />
    <SearchCard />

    <ResponsiveCard />
  </div>
</template>

<script setup>
import { usePlanStore } from '@/store/system/plan'

import ResponsiveCard from './contents/ResponsiveCard.vue'
import PlanRanking from './contents/PlanRanking.vue'
import SearchCard from './search/SearchCard.vue'
import AddForm from './forms/AddForm.vue'
import EditForm from './forms/EditForm.vue'

const $plan = usePlanStore();
</script>
