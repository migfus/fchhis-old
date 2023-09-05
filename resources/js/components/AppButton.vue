<template>
    <button :class="['btn', color, size, mr, ml, push]" :type="type" :disabled="$props.disabled"
        :data-dismiss="$props.dataDismiss">
        <i v-if="$props.disabled" class="mr-1 fa fa-ban"></i>
        <i v-else-if="$props.loading" class="fa fa-circle-notch fa-spin"></i>
        <i v-else-if="$props.icon" :class="['fa', $props.icon, hasSlot ? 'mr-1' : '']"></i>
        <slot v-if="!$props.loading"></slot>
        <!-- {{ hasSlot }} -->
    </button>
</template>

<script setup lang="ts">
import { computed, useSlots } from 'vue'

const $props = defineProps<{
    color?: string
    size?: string
    icon?: string
    loading?: boolean
    disabled?: boolean
    dataDismiss?: string // for modal (no function, for error fix)
    mr?: string
    ml?: string
    push?: string
    type?: string
}>()

const $slot = useSlots()
function hasSlot(name) {
    return !!$slot[name];
}

const color = computed(() => {
    switch ($props.color) {
        case 'warning':
            return 'btn-warning'
        case 'info':
            return 'btn-info'
        case 'secondary':
            return 'btn-secondary'
        case 'danger':
            return 'btn-danger'
        case 'success':
            return 'btn-success'
        default:
            return 'btn-primary'
    }
})

const size = computed(() => {
    switch ($props.size) {
        case 'sm':
            return 'btn-sm'
        default:
            return ''
    }
})
const mr = computed(() => {
    switch ($props.mr) {
        case `1`:
            return 'mr-1'
        case `2`:
            return 'mr-2'
        default:
            return ''
    }
})
const ml = computed(() => {
    switch ($props.ml) {
        case `1`:
            return 'ml-1'
        case `2`:
            return 'ml-2'
        default:
            return ''
    }
})
const push = computed(() => {
    switch ($props.push) {
        case 'right':
            return 'float-right'
        default:
            return ''
    }
})
const type = computed(() => {
    switch ($props.type) {
        case 'submit':
            return 'submit'
        default:
            return 'button'
    }
})
</script>
