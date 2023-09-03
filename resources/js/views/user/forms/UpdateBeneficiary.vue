<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Update Beneficiary</h3>
        </div>

        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input v-model="$ben.params.name" type="text" class="form-control" id="exampleInputEmail1"
                    placeholder="Enter Name">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">BirthDay</label>
                <input v-model="$ben.params.bday" type="date" class="form-control" id="exampleInputEmail1"
                    placeholder="Enter Name">
            </div>
            <button @click="$ben.ResetParams()" class="btn btn-sm btn-danger float-right"><i
                    class="fas fa-times mr-1"></i>Cancel</button>
            <button @click="$ben.UpdateAPI()" class="btn btn-sm btn-warning float-right mr-2"
                :disabled="$ben.params.bday == '' || $ben.params.name == ''"><i class="fas fa-pen mr-1"></i>Update</button>
        </div>

    </div>
</template>

<script setup lang="ts">
import { useUserDetailBeneficiariesStore } from '@/store/@staff/UserDetailBeneficiariesStore'

const $ben = useUserDetailBeneficiariesStore();
</script>
