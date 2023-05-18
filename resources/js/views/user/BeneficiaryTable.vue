<template>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Beneficiaries</h3>
    </div>

    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Progress</th>
            <th style="width: 40px">Label</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in content" :key="row.id">
            <td>{{ row.person.name }}</td>
            <td>Update software</td>
            <td>
              <div class="progress progress-xs">
                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
              </div>
            </td>
            <td><span class="badge bg-danger">55%</span></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { $DebugInfo, $Err } from '@/helpers/debug'
import axios from 'axios'

$DebugInfo('BeneficiaryVue')
const $route = useRoute();

const content = ref([
  {
    id: 1,
    person: {
      lastName: 'John',
      firstName: 'Doe',
      midName: 'John',
      extName: 'Jr',
    },
    bday: '2022-02-02',
    created_at: '2022-02-02'
  },
  {
    id: 1,
    person: {
      lastName: 'John',
      firstName: 'Doe',
      midName: 'John',
      extName: 'Jr',
    },
    bday: '2022-02-02',
    created_at: '2022-02-02'
  }
]);
const config = reactive({
  loading: false,
})

async function GetAPI(id) {
  config.loading = true;
  try {
    let { data: { data } } = await axios.get('/api/beneficiary', { params: { id: id } })
    content.value = data
  }
  catch (e) {
    $Err('BeneficiaryVue GetAPI', { e })
  }
  config.loading = false;
}

onMounted(() => {
  GetAPI($route.params.id)
});
</script>
