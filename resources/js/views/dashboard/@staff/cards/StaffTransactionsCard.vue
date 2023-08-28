<template>
    <div v-if="$trans.content" class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">New Transactions</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Agent</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $trans.content">
                        <td>
                            <img :src="row.client.avatar" class="mr-2" style="height: 30px; width: 30px" />
                            {{ row.client.name }}
                        </td>
                        <td>
                            <strong class="text-success">
                                +{{ NumberAddComma(row.amount) }}
                            </strong>
                        </td>
                        <td>
                            <img :src="row.agent.avatar" class="mr-2" style="height: 30px; width: 30px" />
                            <strong class="text-success">
                                {{ row.agent.name }}
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
import { useTransactionDashboardStore } from '@/store/@staff/TransactionDashboardStore'
import { onMounted } from 'vue'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $trans = useTransactionDashboardStore();

onMounted(() => {
    $trans.GetAPI()
})

// onUnmounted(() => {
//   $trans.content = []
// });
</script>
