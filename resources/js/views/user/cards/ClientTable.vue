<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Transactions</h3>
            <button class="btn btn-success btn-sm float-right">Add Transaction</button>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Agent Name</th>
                        <th>Plan</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $user.content.client_transactions" :key="row.id">
                        <td>{{ row.agent.name }}</td>
                        <td>
                            <img :src="row.plan.avatar" style="height: 20px; width: 20px"
                                class="img-circle float-left mr-2">
                            {{ `${row.plan.name} (${row.pay_type.name})` }}
                        </td>
                        <td class="text-success text-bold">
                            +{{ NumberAddComma(row.amount) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore'
import moment from 'moment'
import { NumberAddComma } from '@/helpers/converter'

const $user = useUserDetailsStore();
</script>
