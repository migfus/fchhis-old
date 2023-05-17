<template>
  <AddCard v-if="$ben.config.form == 'add'" />
  <UpdateCard v-if="$ben.config.form == 'update'" />
  <div class="card">

    <div class="card-header">
      <h4 class="card-title"><strong>Beneficiaries</strong></h4>

      <div class="card-tools">
        <div class="input-group input-group-sm">
          <input v-model="$ben.query.search" type="text" name="table_search" class="form-control float-right"
            placeholder="Search">
          <div class="input-group-append">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-search"></i>
            </button>
            <button v-if="$ben.config.form == ''" @click="$ben.ChangeForm('add')" class="btn btn-success">
              Add
            </button>
            <button v-else @click="$ben.ChangeForm('')" class="btn btn-danger">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <table class="table table-hover text-nowrap">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th width="100">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row, idx in $ben.content">
            <td>{{ FullNameConvert(row) }}</td>
            <td>{{ AgeConverter(row.bday) }}</td>
            <td>
              <button @click="$ben.Edit(row)" class="btn btn-info btn-sm mr-1"><i class="fas fa-pen"></i></button>
              <button @click="$ben.DeleteAPI(row.id, idx)" class="btn btn-danger btn-sm px-2"><i
                  class="fas fa-times"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { useBeneficiaryStore } from '@/store/dashboard/beneficiary'
import { onMounted } from 'vue'
import { FullNameConvert, AgeConverter } from '@/helpers/converter'
import { watch } from 'vue'
import { throttle } from 'lodash'

import AddCard from '../forms/AddCard.vue'
import UpdateCard from '../forms/UpdateCard.vue'

const $ben = useBeneficiaryStore();

onMounted(() => {
  $ben.GetAPI()
});

watch($ben.query, throttle(() => {
  $ben.GetAPI(1)
}, 1000));
</script>
