<template>
  <div v-for="row in $role.content" :key="row.id" class="col-md-6 col-12">


    <div :class="`card mb-2`">
      <div class="card-header">
        <div>
          <div class="row">
            <div class="col-12">
              <div class="card-tools float-right">
                <strong>{{ row.count }}</strong> Users
              </div>

              <div :class="`d-flex justify-content-center align-items-center img-circle float-left mr-3 bg-${row.color}`"
                style="width: 40px; height: 40px">
                <i :class="`fas ${row.icon}`"></i>
              </div>
              <div> <strong> {{ row.name }} </strong> </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
          <thead>
            <tr>
              <th>Username</th>
              <th>Email</th>
              <th>More</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row2 in row.top" :key="row2.id">
              <td>
                <img :src="row2.avatar" alt="Product 1" class="img-circle img-size-32 mr-2">
                {{ row2.username }}
              </td>
              <td>{{ FullNameConvert(row2.email) }}</td>
              <td>
                <a href="#" class="text-muted">
                  <i class="fas fa-search"></i>
                </a>
              </td>
            </tr>
            <tr v-if="row.top">
              <td>
                <RouterLink :to="{ name: 'users-list' }">More Users</RouterLink>
              </td>
            </tr>
          </tbody>
        </table>
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
