<template>
    <AddBeneficiary v-if="$bent.config.form == 'add'" />
    <UpdateBeneficiary v-if="$bent.config.form == 'update'" />
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Beneficiaries</h3>
            <AppButton @click="$bent.config.form = 'add'" color="success" push="right" icon="fa-plus">
                Add
            </AppButton>
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
                    <tr v-for="row in $bent.content" :key="row.id">
                        <td>{{ row.name }}</td>
                        <td>{{ `${moment(row.bday).format('MMM D, YYYY')} (${AgeConverter(row.bday)})` }}</td>
                        <td>
                            <AppButton @click="deleteBen(row.id)" color="danger" push="right" icon="fa-times" size="sm" />
                            <AppButton @click="$bent.Update(row)" color="warning" push="right" mr="1" icon="fa-pen"
                                size="sm" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup lang="ts">
import moment from 'moment'
import { AgeConverter } from '@/helpers/converter'
import { useUserDetailBeneficiariesStore } from '@/store/@staff/UserDetailBeneficiariesStore'
import { onMounted } from 'vue'

import AddBeneficiary from '../forms/AddBeneficiary.vue'
import UpdateBeneficiary from '../forms/UpdateBeneficiary.vue'
import AppButton from '@/components/AppButton.vue'

const $bent = useUserDetailBeneficiariesStore();

function deleteBen(id: number) {
    if (confirm('Do you want to remove?') == true) {
        $bent.DestroyAPI(id)
    }
}

onMounted(() => {
    $bent.GetAPI()
})
</script>
