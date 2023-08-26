<template>
    <div>
        <StatRow />

        <div class="row">
            <div class="col-12 col-md-6">
                <ShortcutCard />
            </div>
            <div class="col-12 col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <ClientsCard />
            </div>
        </div>

        <!-- <ClientsCard /> -->
    </div>
</template>

<script setup lang="ts">
// import ClientsCard from './ClientsCard.vue'
import StatRow from './StatRow.vue'
import ShortcutCard from './ShortcutCard.vue'
import ClientsCard from './ClientsCard.vue'
</script>
