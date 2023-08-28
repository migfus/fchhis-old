<template>
    <div>
        <StatRow />

        <div class="row">
            <div class="col-12 col-md-6">
                <ShortcutCard />
            </div>
            <div class="col-12 col-md-6">
                <TransactionCard />
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <ClientsCard />
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
// import ClientsCard from './ClientsCard.vue'
import StatRow from './cards/StatRow.vue'
import ShortcutCard from './cards/ShortcutCard.vue'
import ClientsCard from './cards/ClientsCard.vue'
import TransactionCard from './cards/StaffTransactionsCard.vue'
</script>
