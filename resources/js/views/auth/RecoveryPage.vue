<template>
  <div class="mb-5 d-flex justify-content-center mt-5">
    <div>

      <div class="login-logo">
        <RouterLink :to="{ name: 'home' }">
          <div>
            <img src="https://fchhis.migfus20.com/images/logo.png" alt="logo" style="width: 150px;">
          </div>
          <div>Future Care & Helping Hands</div>
          <div>Insurance Service</div>
        </RouterLink>
      </div> <!--SECTION LOGO-->

      <div v-if="$auth.config.confirm" class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">We will send you a link for password recovery</p>
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount
            @submit="$auth.ChangePasswordAPI(input)">

            <div class="input-group">
              <Field v-model="input.newPassword" name="newPassword" type="password" class="form-control"
                placeholder="New Password" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="mb-3 text-danger">
              <ErrorMessage name="newPassword" />
            </div>
            <div class="input-group">
              <Field v-model="input.confirmPassword" name="confirmPassword" type="password" class="form-control"
                placeholder="Confirm Password" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-check-circle"></span>
                </div>
              </div>
            </div>
            <div class="mb-3 text-danger">
              <ErrorMessage name="confirmPassword" />
            </div>

            <div class="row">
              <div class="col-8">

              </div>

              <div class="col-12">
                <button v-if="$auth.config.loading" class="btn btn-info btn-block" disabled><i
                    class="fas fa-circle-notch fa-spin"></i></button>
                <button v-else type="submit" class="btn btn-info btn-block"
                  :disabled="Object.keys(errors).length != 0">Change Password</button>
              </div>

            </div>
          </Form>

          <p class="mb-1 mt-2">
            <RouterLink :to="{ name: 'login' }">Back to login</RouterLink>
          </p>
        </div>

      </div> <!-- SECTION LOGO -->

      <div v-else class="card">
        <div class="card-body">
          Your code is expired: {{ $route.query.code }}
          <div class="text-info">Please try to resend recovery link</div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup lang="ts">
type inputType = {
  newPassword: string
  confirmPassword: string
  code: string
}

import { Form, Field, ErrorMessage, configure } from 'vee-validate'
import * as Yup from 'yup'
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '@/store/auth/AuthStore'
import { useRoute } from 'vue-router'

configure({
  validateOnInput: true,
})

const $auth = useAuthStore();
const $route = useRoute();

const schema = Yup.object({
  newPassword: Yup.string().required('New Password Required').min(8, 'Minimum of 8 Characters'),
  confirmPassword: Yup.string().oneOf([Yup.ref('newPassword'), null], 'Password must match to New Password')
})

const input = reactive<inputType>({
  newPassword: '',
  confirmPassword: '',
  code: $route.query.code.toString()
});

onMounted(() => {
  $auth.ConfirmRecoveryAPI({ code: $route.query.code.toString() })
});
</script>

<style scoped>
a {
  color: var(--info)
}
</style>
