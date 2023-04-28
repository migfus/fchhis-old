<template>
  <div :class="`tab-pane fade ${$props.active ? 'active show' : ''}`" id="notification" role="tabpanel"
    aria-labelledby="password-tab">

    <div class="card-body">
      <form @submit="Update">
        <div class="row">

          <div class="col-md-6">
            <label for="new-password">Email</label>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.email.system" type="checkbox" class="custom-control-input" id="email-system">
                <label class="custom-control-label" for="email-system">System Notification</label>
              </div>
            </div>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.email.registered" type="checkbox" class="custom-control-input"
                  id="email-registered">
                <label class="custom-control-label" for="email-registered">New Registered</label>
              </div>
            </div>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.email.registered" type="checkbox" class="custom-control-input" id="customSwitch3">
                <label class="custom-control-label" for="customSwitch3">New Registered</label>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="new-password">Web Push</label>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.push.system" type="checkbox" class="custom-control-input" id="push-system">
                <label class="custom-control-label" for="push-system">System Notification</label>
              </div>
            </div>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.push.registered" type="checkbox" class="custom-control-input" id="push-registered">
                <label class="custom-control-label" for="push-registered">New Registered</label>
              </div>
            </div>

            <div class="form-group">
              <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input v-model="input.push.registered" type="checkbox" class="custom-control-input" id="customSwitch3">
                <label class="custom-control-label" for="customSwitch3">New Registered</label>
              </div>
            </div>
          </div>
        </div>

      </form>

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


