<template>
    <AddBeneficiary v-if="$bent.config.form == 'add'" />
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Beneficiaries</h3>
            <button @click="$bent.config.form = 'add'" class="btn btn-sm btn-success float-right">
                <i class="fas fa-plus mr-2"></i>Add
            </button>
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
                            <!-- <button class="btn btn-info btn-sm mr-2"><i class="fas fa-pen"></i></button> -->
                            <button @click="deleteBen(row.id)" class="btn btn-danger btn-sm"><i
                                    class="fas fa-trash"></i></button>
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
import { useRoute } from 'vue-router'
import AddBeneficiary from '../forms/AddBeneficiary.vue'

const $route = useRoute();
const $bent = useUserDetailBeneficiariesStore();

function deleteBen(id: number) {
    if (confirm('Do you want to remove?') == true) {
        $bent.DestroyAPI(id)
    }
}

onMounted(() => {
    $bent.params.userId = Number($route.params.id)
    $bent.GetAPI()
})
</script>
