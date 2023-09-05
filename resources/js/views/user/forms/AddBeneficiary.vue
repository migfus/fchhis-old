<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Add Beneficiary</h3>
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

            <AppButton @click="$ben.ResetParams()" color="danger" push="right" icon="fa-times">
                Cancel
            </AppButton>
            <AppButton @click="$ben.StoreAPI()" color="info" push="right" icon="fa-times" mr="1"
                :disabled="$ben.params.bday == '' || $ben.params.name == ''">
                Add
            </AppButton>
        </div>

    </div>
</template>

<script setup lang="ts">
import { useUserDetailBeneficiariesStore } from '@/store/@staff/UserDetailBeneficiariesStore'

import AppButton from '@/components/AppButton.vue';

const $ben = useUserDetailBeneficiariesStore();
</script>
