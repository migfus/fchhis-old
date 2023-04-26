<template>
  <div v-if="$auth.auth.role == 2">
    <UserSummaryAdmin v-if="$dashboard.content" />
    <TopPerformerAdmin v-if="$dashboard.content" />
    <AdminSectionAdmin />
  </div>
  <div v-else>
    <ClientDashboard />
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useDashboardStore } from '@/store/system/dashboard'
import { useAuthStore } from '@/store/auth/auth'

import AdminSectionAdmin from './admin/AdminSection.vue';
import UserSummaryAdmin from './admin/UserSummary.vue';
import TopPerformerAdmin from './admin/TopPerformer.vue';

import ClientDashboard from './client/ClientDashboard.vue';

const $dashboard = useDashboardStore();
const $auth = useAuthStore();

onMounted(() => {
  $dashboard.GetAPI($auth.auth.role);
});
</script>
