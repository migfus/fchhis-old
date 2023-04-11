<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="row">

                <div class="col-6">
                  <div class="form-group mb-0">
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
          </div>
        </div>

        <div class="col-12">
          <div v-for="(row, idx,) in table.data" class="card">
            <div class="body mx-3 my-2">
              <img :src="row.avatar" style="height: 3em;" class="img-circle">
            </div>
          </div>
        </div>

        <div class="col-12">
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
