<template>
  <div class="row">
    <!-- NOTE ADD/EDIT -->
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Add User</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
          </div>
          <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
          </div>
          <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <div class="input-group">
          <div class="custom-file">
          <input type="file" class="custom-file-input" id="exampleInputFile">
          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
          </div>
          <div class="input-group-append">
          <span class="input-group-text">Upload</span>
          </div>
          </div>
          </div>
          <div class="form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1">
          <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
        </div>
      </div>
    </div>

    <!-- NOTE SEARCH -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">

            <div class="col-12">
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Notify</strong> We don't recommend to delete some records, it will reflect everything that they transact.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

            <div class="col-12 col-md-4 mb-2">

              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                </div>
                <select v-model="role" class="form-control">
                  <option :value="7">All (Role)</option>
                  <option :value="2">Admin</option>
                  <option :value="3">Manager</option>
                  <option :value="4">Agent</option>
                  <option :value="5">Staff</option>
                  <option :value="6">Client</option>
                  <option :value="0">Inactive</option>
                  <option :value="1">Banned</option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-4 mb-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-filter"></i></span>
                </div>
                <select v-model="filter" class="form-control">
                  <option value="">All (Filter)</option>
                  <option value="name">Name</option>
                  <option value="email">Email</option>
                  <option value="address">Address</option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-4">
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

          <div class="row mt-2">
            <div class="col-12 col-md-4 mb-2">
              <VueDatePicker
                v-model="dateRange.start"
                :start-date="moment().startOf('month').format('YYYY-MM-DD')"
                :enable-time-picker="false"
                auto-apply
                placeholder="Start Date"
              />
            </div>
            <div class="col-12 col-md-4 mb-2">
              <VueDatePicker
                v-model="dateRange.end"
                :start-date="moment().endOf('month').format('YYYY-MM-DD')"
                :enable-time-picker="false"
                auto-apply
                placeholder="End Date"
              />
            </div>

            <div class="col-12 col-md-4">
              <button class="btn btn-success float-right">
                <i class="fas fa-plus-square d-inline d-xl-none"></i>
                <span class="d-none d-xl-inline">Add User</span>
              </button>

              <button @click="tableView = !tableView" class="btn btn-info mr-1 float-right">
                <i :class="`fas ${tableView ? 'fa-bars' : 'fa-table'}`"></i>
              </button>
              <button @click="viewAll = !viewAll" :disabled="tableView" class="btn btn-info mr-1 float-right">
                <i :class="`fas ${viewAll ? 'fa-window-minimize' : 'fa-window-maximize'}`"></i>
              </button>
              <button class="btn btn-info mr-1 float-right">
                <i class="fas fa-print"></i>
              </button>

            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- NOTE TABLE -->
    <div v-if="tableView" class="col-12">
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
      </div>

    </div>

    <!-- NOTE MOBILE -->
    <div v-else class="col-12">

      <div v-for="(row, idx,) in table.data" :class="`card mb-2 ${viewAll ? '' : 'collapsed-card'}`">
        <div class="card-header">

          <div data-card-widget="collapse" ref="collapse-click">
            <div class="row">
              <div class="col-12 col-md-6 col-xl-4">
                <span class="d-inline d-md-none float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }}  </span>
                <img :src="row.avatar" style="height: 2em;" class="img-circle float-left mr-3">
                <BadgeComponent :role="row.role"/>
                <div><strong>Schwarzenegger R. Belonio</strong></div>
                <div><strong>{{ row.username }}</strong></div>
              </div>
              <div class="d-none d-md-inline col-md-6 col-xl-4">
                <span class="d-inline d-xl-none float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }}  </span>
                <div>Email: <strong>{{ row.email }}</strong></div>
                <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
              </div>
              <div class="d-none d-xl-inline col-12 col-md-6 col-xl-4">
                <span class="float-right text-secondary"> {{ moment(row.created_at).local().format('MMM D, YYYY') }} </span>
                <div>Plan: <strong>Jade</strong></div>
                <div>Total: <strong>12,000</strong></div>
              </div>
            </div>

          </div>

        </div>

        <div class="card-body">
          <div class="row mb-2">
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
              <div>Refered: <strong>Juan Do do</strong></div>
              <div>Plan: <strong>Jade</strong></div>
              <div>Transact: <strong>1,000</strong></div>
              <div>Accumulated: <strong>2,000</strong></div>
              <div>Total: <strong>12,089</strong></div>
              <hr class="mt-1"/>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
              <div>Username: <strong>{{ row.username }}</strong></div>
              <div>Email: <strong>{{ row.email }}</strong></div>
              <div>Name: <strong>Schwarzenegger R. Belonio</strong></div>
              <div>Birth Day: <strong>Sep 31, 2022 (20 yrs)</strong></div>
              <div>Birth Place: <strong>Valencia City, Bukidnon</strong></div>
              <hr class="mt-1"/>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">

              <div>Created On: <strong>{{  moment(row.created_at).local().format('MMM DD, YYYY h:mm A') }}</strong></div>
              <div>Encoded By: <strong>Juan De Loslos</strong></div>
              <div>Role: <strong>{{ RoleToDesc(row.role) }}</strong></div>
              <div>Phone: <strong>0997-866-3855</strong></div>
              <div>Last Active: <strong>Sep 31, 2022</strong></div>
              <hr class="mt-1"/>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
              <div>Province: <strong>Bukidnon</strong></div>
              <div>City: <strong>Valencia City</strong></div>
              <div>Address: <strong>123 St. Roxina Taboboy</strong></div>
              <div>Sex: <strong>Male</strong></div>
              <div>Address: <strong>123 St. Roxina Taboboy</strong></div>
              <hr class="mt-1"/>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button @click="Delete(row.id, idx)" class="btn btn-danger btn-sm float-right">
                Remove
              </button>
              <button @click="Update()" class="btn btn-secondary btn-sm float-right mr-1">
                Edit
              </button>
              <button class="btn btn-secondary btn-sm float-right mr-1">
                Info
              </button>
            </div>
          </div>

        </div>

      </div>

    </div>

    <!-- NOTE PAGINATION -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <Bootstrap5Pagination :data="table" :limit="2" @pagination-change-page="GetAPI" class="float-right mb-0" />
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, watch, reactive } from 'vue'
import { RoleToDesc } from '../../helpers/converter';
import axios from 'axios'
import { useToast } from 'vue-toastification';
import { useAuthStore } from '@/store/auth/auth';
import { useRoute } from 'vue-router'
import { throttle } from 'lodash'
import moment from 'moment'
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'

import Bootstrap5Pagination from '@/components/Bootstrap5Pagination.vue';
import BadgeComponent from './BadgeComponent.vue'


const $toast = useToast();
const $auth = useAuthStore();
const $route = useRoute();

const table = ref([]);
const role = ref(7)
const filter = ref('')
const search = ref('')
const loading = ref(false)
const tableView = ref(false)
const viewAll = ref(false)
const dateRange = reactive({
  start: '',
  end: '', //moment().local().endOf('month').format('YYYY-MM-DD'),
})

async function GetAPI(page = 1) {
  loading.value = true
  try {
    let { data: { data } } = await axios.get(`/api/users`, {
      params: {
        page: page,
        role: role.value,
        search: search.value,
        start: dateRange.start,
        end: dateRange.end,
        filter: filter.value,
      }
    })
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
  window.scrollTo({
    top: 0,
    left: 0,
    behavior: 'smooth'
  });
  $toast.warning('update')
}

watch(search, throttle(() => {
  GetAPI(1)
}, 1000))

watch(role, () => {
  GetAPI(1)
})

watch(filter, () => {
  GetAPI(1)
})

watch(dateRange, () => {
  GetAPI(1)
})


onMounted(() => {
  GetAPI()
});
</script>
