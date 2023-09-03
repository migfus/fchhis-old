<template>
    <TransitionGroup name="list">
        <slot></slot>
    </TransitionGroup>
</template>

<script setup lang="ts">

</script>

<style scoped>
.list-enter,
.list-leave-to {
    opacity: 0
}

.list-leave,
.list-enter-to {
    opacity: 1
}

.list-enter-active,
.list-leave-active {
    transition: opacity 300ms
}
</style>
