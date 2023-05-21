<template>
  <div v-if="$ben.content" class="card">
    <div class="card-header">
      <h3 class="card-title text-bold">Beneficiaries</h3>
      <button @click="$ben.ChangeForm('add')" class="btn btn-sm btn-success float-right"><i class="fas fa-plus"></i>
        Add</button>
    </div>

    <div class="card-body p-0">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>BirthDay</th>
            <th style="width: 110px">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in $ben.content" :key="row.id">
            <td>{{ row.name }}</td>
            <td>{{ `${moment(row.bday).format('MMM D, YYYY')} (${AgeConverter(row.bday)})` }}</td>
            <td>
              <button class="btn btn-info btn-sm mr-2"><i class="fas fa-pen"></i></button>
              <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'
import { useBeneficiaryStore } from '@/store/users/BeneficiaryStore'
import moment from 'moment'
import { AgeConverter } from '@/helpers/converter'

const $route = useRoute();
const $ben = useBeneficiaryStore();

onMounted(() => {
  $ben.query.id = $route.params.id
  $ben.GetAPI()
});

onUnmounted(() => {
  $ben.content = []
});
</script>
