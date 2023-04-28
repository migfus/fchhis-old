<template>
  <div v-if="$auth.auth.role == 2">
    <UserSummaryAdmin v-if="$dashboard.content" />
    <TopPerformerAdmin v-if="$dashboard.content" />
    <AdminSectionAdmin v-if="$dashboard.content" />
  </div>
  <div v-else-if="$auth.auth.role == 4">
    <AgentCard v-if="$dashboard.content" />
    <ClientDashboard v-if="$dashboard.content" />
  </div>
  <div v-else-if="$auth.auth.role == 5">
    <StaffCard v-if="$dashboard.content" />
  </div>
  <div v-else>
    <ClientDashboard v-if="$dashboard.content" />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useDashboardStore } from '@/store/dashboard/dashboard'
import { useAuthStore } from '@/store/auth/auth'

import AdminSectionAdmin from './admin/AdminSection.vue';
import UserSummaryAdmin from './admin/UserSummary.vue';
import TopPerformerAdmin from './admin/TopPerformer.vue';

import ClientDashboard from './client/ClientDashboard.vue';
import AgentCard from './agent/AgentCard.vue';
import StaffCard from './staff/StaffCard.vue';

const $dashboard = useDashboardStore();
const $auth = useAuthStore();

onMounted(() => {
  $dashboard.GetAPI($auth.auth.role);
});
</script>
