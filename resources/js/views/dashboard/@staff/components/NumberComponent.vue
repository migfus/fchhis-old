<template>
    <span class="info-box-number">
        <div v-if="$props.data.current > 0">
            <span class="text-success">+{{ $props.data.current }}</span> | {{ $props.data.total }}
        </div>
        <div v-else>
            0 | {{ $props.data.total }}
        </div>
    </span>
</template>
<script setup lang="ts">
const $props = defineProps({
    data: {
        type: Object,
        default: 0,
    }
})
</script>
