<template>
  <div v-if="$user.config.tableView" class="col-12">
    <div class="card table-responsive ">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>Avatar</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, idx,) in $user.list.data" :key="row.name">
            <td width="16px">
              <img class="img-circle" :src="row.avatar" style="height: 2em;">
              <span v-if="row.role == 2" class="badge badge-warning badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-crown"></i>
              </span>
              <span v-else-if="row.role == 3" class="badge badge-warning badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-tasks"></i>
              </span>
              <span v-else-if="row.role == 4" class="badge badge-info badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-hands-helping"></i>
              </span>
              <span v-else-if="row.role == 5" class="badge badge-success badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-user-edit"></i>
              </span>
              <span v-else-if="row.role == 6" class="badge badge-secondary badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-user"></i>
              </span>
              <span v-else-if="row.role == 0" class="badge badge-danger badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-moon"></i>
              </span>
              <span v-else class="badge badge-danger badge-left"
                style="position: relative; left: -10px; top: 7px; border-radius: 50px">
                <i class="fas fa-ban"></i>
              </span>
            </td>
            <td>{{ row.username }}</td>
            <td>{{ row.email }}</td>
            <td width="100px">{{ RoleToDesc(row.role) }}</td>
            <td width="100px">{{ moment().from(row.created_at) }}</td>
            <td width="10px">
              <button @click="Delete(row.id, idx)" class="btn btn-danger mr-1 btn-sm"
                :disabled="row.id == $auth.auth.id"><i class="fas fa-times"></i></button>
              <button @click="Info" class="btn btn-info btn-sm mr-1"><i class="fas fa-info-circle"></i></button>
              <button @click="Update" class="btn btn-info btn-sm"><i class="fas fa-pen"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup lang="ts">
import { useUsersStore } from '@/store/users/UsersStore'
import moment from 'moment'
import { RoleToDesc } from '@/helpers/converter';
import { useAuthStore } from '@/store/auth/AuthStore'

const $auth = useAuthStore();
const $user = useUsersStore();
</script>
