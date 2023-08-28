<template>
    <div v-if="$users.content" class="card">

        <div class="card-header">
            <h4 class="card-title"><strong>Beneficiaries</strong></h4>

            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <input v-model="$users.query.search" type="text" name="table_search" class="form-control float-right"
                        placeholder="Search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i v-if="$users.config.loading" class="fas fa-circle-notch fa-spin"></i>
                            <i v-else class="fas fa-search"></i>
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
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $users.content">
                        <td>{{ row.name }}</td>
                        <td>{{ AgeConverter(row.bday) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup lang='ts'>
import { useBeneficiariesStore } from '@/store/@client/BeneficiariesStore'
import { onMounted, onUnmounted, watch } from 'vue'
import { AgeConverter } from '@/helpers/converter'
import { throttle } from 'lodash'

const $users = useBeneficiariesStore();

onMounted(() => {
    $users.GetAPI()
})
onUnmounted(() => {
    $users.CancelAPI()
})

watch($users.query, throttle(() => {
    $users.GetAPI()
}, 2000))
</script>
