<template>
  <div :class="`tab-pane fade ${$props.active ? 'active show' : ''}`" id="preference" role="tabpanel"
    :aria-labelledby="$props.id">

    <div class="card-body">
      test

    </div>

  </div>
</template>

<script setup>
import { reactive } from 'vue';
import axios from 'axios'
import { useToast } from 'vue-toastification';

const input = reactive({
  email: {
    system: true,
    registered: false
  },
  push: {
    system: false,
    registered: true
  }
})

const $props = defineProps(['active', 'id']);
const $toast = useToast();

async function Update() {
  try {
    const { data } = await axios.post('/api/change-notification', input)
    $toast.success('Successfuly Changed')
    Object.assign(input, { currentPassword: '', newPassword: '', confirmPassword: '' })
  }
  catch (e) {
    $toast.error('Internet Error')
  }
}
</script>


