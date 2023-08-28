<template>
    <div v-if="$clients.content" class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">New Clients</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Accumulated</th>
                        <th>Agent</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $clients.content">
                        <td>
                            <img :src="row.avatar" class="mr-2" style="height: 30px; width: 30px" />
                            {{ row.name }}
                        </td>
                        <td>
                            <strong class="text-success">
                                +{{ NumberAddComma(row.client_transactions_sum_amount) }}
                            </strong>
                        </td>
                        <td>
                            <img :src="row.info.agent.avatar" class="mr-2" style="height: 30px; width: 30px" />
                            <strong class="text-success">
                                {{ row.info.agent.name }}
                            </strong>
                        </td>
                        <td>
                            <div>
                                {{ moment(row.created_at).fromNow(true) }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { useClientsDashboardStore } from '@/store/@staff/ClientsDashboardStore'
import { onMounted, onUnmounted } from 'vue'
import { NumberAddComma } from '@/helpers/converter'
import moment from 'moment'

const $clients = useClientsDashboardStore();

onMounted(() => {
    $clients.GetAPI()
})
onUnmounted(() => {
    $clients.CancelAPI()
});
</script>
