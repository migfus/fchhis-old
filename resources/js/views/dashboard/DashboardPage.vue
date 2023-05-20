<template>
  <!-- SECTION ADMIN -->
  <div v-if="$auth.auth.role == 2">
    <UserSummaryAdmin v-if="$dashboard.content" />
    <TopPerformerAdmin v-if="$dashboard.content" />
    <AdminSectionAdmin v-if="$dashboard.content" />
  </div>
  <!-- SECTION AGENT -->
  <div v-else-if="$auth.auth.role == 4">
    <AgentCard v-if="$dashboard.content" />
    <ClientDashboard v-if="$dashboard.content" />
  </div>
  <!-- SECTION STAFF -->
  <div v-else-if="$auth.auth.role == 5">
    <StaffCard v-if="$dashboard.content" />
  </div>
  <!-- SECTION CLIENT -->
  <div v-else>
    <ClientDashboard v-if="$dashboard.content" />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useStatisticStore } from '@/store/dashboard/StatisticStore'
import { useAuthStore } from '@/store/auth/AuthStore'

import AdminSectionAdmin from './admin/AdminSection.vue';
import UserSummaryAdmin from './admin/UserSummary.vue';
import TopPerformerAdmin from './admin/TopPerformer.vue';

import ClientDashboard from './client/ClientPage.vue';
import AgentCard from './agent/AgentCard.vue';
import StaffCard from './staff/StaffCard.vue';

const $stat = useStatisticStore();
const $auth = useAuthStore();

onMounted(() => {
  $stat.GetAPI();
});
</script>
