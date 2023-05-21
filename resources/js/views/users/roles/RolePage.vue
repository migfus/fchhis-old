<template>
  <div class="row">
    <ResponsiveCard v-if="$role.content" />
  </div>
</template>

<script setup>
import ResponsiveCard from './contents/ResponsiveCard.vue';
import { onMounted } from 'vue';
import { useRoleStore } from '@/store/users/RoleStore';

const $role = useRoleStore();

onMounted(() => {
  $role.GetAPI()
});
</script>

