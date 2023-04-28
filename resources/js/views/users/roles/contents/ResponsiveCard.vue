<template>
  <div v-for="row in $role.content" :key="row.id" class="col-md-4 col-12">

    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
          <h6 class="fw-normal">Total {{ row.count }} users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li v-for="row2 in row.top" class="avatar avatar-sm pull-up">
              <img :src="row2.avatar" class="rounded-circle" style="width: 40px; height: 40px;">
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h4 class="mb-1">{{ row.name }}</h4>
          </div>
          <a href="javascript:void(0);" class="text-muted"><i :class="`fas ${row.icon} text-${row.color}`"></i></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useRoleStore } from '@/store/users/role';
import { FullNameConvert } from '@/helpers/converter'

const $role = useRoleStore();

onMounted(() => {
  $role.RoleGetAPI()
});
</script>

<style scoped>
.avatar-group .avatar-sm {
  margin-left: -0.75rem;
}

.avatar {
  border: 5px solid #c9dfe2;
  border-radius: 50px
}
</style>
