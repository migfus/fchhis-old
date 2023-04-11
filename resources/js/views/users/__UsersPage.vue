<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row">

                <div class="col-6">
                  <div class="form-group">
                    <select v-model="role" class="form-control">
                      <option :value="2">Admin</option>
                      <option :value="3">Manager</option>
                      <option :value="4">Agent</option>
                      <option :value="5">Staff</option>
                      <option :value="6">Client</option>
                      <option :value="0">Inactive</option>
                      <option :value="1">Banned</option>
                      <option :value="7">All</option>
                    </select>
                  </div>
                </div>

                <div class="col-6">
                  <div class="input-group input-group float-right">
                    <input v-model="search" type="text" name="table_search" class="form-control float-right"
                      placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i :class="`fas ${loading ? 'fa-spinner fa-spin' : 'fa-search'}`"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body table-responsive p-0">
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
                  <tr v-for="(row, idx,) in table.data" :key="row.name">
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

            </div> <!-- CARD GBODY-->


          </div>

          <div class="card">
            <div class="card-body">
              <Bootstrap5Pagination :data="table" :limit="2" @pagination-change-page="GetAPI" class="float-right mb-0" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { RoleToDesc } from '../../helpers/converter';
import axios from 'axios'
import { useToast } from 'vue-toastification';
import { useAuthStore } from '@/store/auth/auth';
import Bootstrap5Pagination from '@/components/Bootstrap5Pagination.vue';
import { useRoute } from 'vue-router'
import { throttle } from 'lodash'
import moment from 'moment'

const $toast = useToast();
const $auth = useAuthStore();
const $route = useRoute();

const table = ref([]);
const role = ref(7)
const search = ref('')
const loading = ref(false)

async function GetAPI(page = 1) {
  loading.value = true
  try {
    let { data: { data } } = await axios.get(`/api/users?page=${page}&role=${role.value}&search=${search.value}`)
    table.value = data
  }
  catch (e) {
    console.log({ e })
  }
  loading.value = false
}

async function Delete(id, idx) {
  if (confirm("Do you want to delete")) {
    table.value.data.splice(idx, 1)
    try {
      let { data } = await axios.delete(`/api/users/${id}`)
      GetAPI()
      console.log({ data })
    }
    catch (e) {
      console.log({ e })
    }
  }
}


function Info() {
  $toast.warning('ifno')
}

function Update() {
  $toast.warning('update')
}

watch(search, throttle(() => {
  GetAPI(1)
}, 1000))
watch(role, () => {
  GetAPI(1)
})
watch($route.meta.role, () => {
  role.value = $route.meta.role
})


onMounted(() => {
  GetAPI()
});
</script>
