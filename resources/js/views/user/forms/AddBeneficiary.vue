<template>
  <div v-if="$ben.content" class="card">
    <div class="card-header">
      <h3 class="card-title text-bold">Add Beneficiary</h3>
    </div>

    <div class="card-body">

      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Sex</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">BirthDay</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Birth Place</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Province</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">City</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Address</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Name">
      </div>

      <button @click="$ben.ChangeForm('')" class="btn btn-sm btn-danger float-right"><i
          class="fas fa-times mr-1"></i>Cancel</button>
      <button class="btn btn-sm btn-info float-right mr-2"><i class="fas fa-plus mr-1"></i>Add</button>
    </div>

  </div>
</template>

<script setup>
import { useBeneficiaryStore } from '@/store/users/BeneficiaryStore'
import moment from 'moment'
import { AgeConverter } from '@/helpers/converter'

const $ben = useBeneficiaryStore();
</script>
