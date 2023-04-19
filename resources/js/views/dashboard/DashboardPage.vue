<template>
  <AdminSection />
  <UserSummary v-if="$dashboard.content.rolesChart" />
  <TopPerformer v-if="$dashboard.content.rolesChart" />
</template>

<script setup>
import { onMounted } from 'vue';
import { useDashboardStore } from '@/store/system/dashboard'

import AdminSection from './AdminSection.vue';
import UserSummary from './UserSummary.vue';
import TopPerformer from './TopPerformer.vue';

const $dashboard = useDashboardStore();

onMounted(() => {
  $dashboard.GetAPI();
});
</script>
