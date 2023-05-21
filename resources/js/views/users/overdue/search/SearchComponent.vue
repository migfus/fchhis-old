<template>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        OVERDUE

      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useUsersStore } from '@/store/users/UsersStore'

const $user = useUsersStore();

onMounted(() => {
  $user.query.limit = 10
  $user.query.role = 6
  $user.query.overdue = true
  $user.GetAPI()
});

onUnmounted(() => {
  $user.content = []
  $user.query.overdue = false
});
</script>
