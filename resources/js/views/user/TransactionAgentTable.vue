<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-bold">Transactions</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="row in $user.content.agent_transactions">
                        <td>{{ `${row.client.name}` }}</td>
                        <td>{{ row.amount }}</td>
                        <td>{{ moment(row.created_at).format('MMM D, YYYY') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { useUserDetailsStore } from '@/store/user/UserDetailStore';
import moment from 'moment'

const $user = useUserDetailsStore();
</script>
