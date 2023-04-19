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

import ResponsiveCard from './ResponsiveCard.vue'
import PlanRanking from './PlanRanking.vue'
import SearchCard from './SearchCard.vue'
import AddForm from './AddForm.vue'
import EditForm from './EditForm.vue'

const $plan = usePlanStore();
</script>
