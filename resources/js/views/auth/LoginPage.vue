<template>
  <div class="mt-5 d-flex justify-content-center">
    <div class="">
      <div class="login-logo">
        <RouterLink :to="{ name: 'home' }">
          <div>
            <img src="https://fchhis.migfus20.com/images/logo.png" alt="logo" style="width: 150px;">
          </div>
          <div>Future Care & Helping Hands</div>
          <div>Insurance Service</div>
        </RouterLink>
      </div>

      <div class="card mb-5">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$auth.LoginAPI(input)">

            <div class="input-group">
              <Field v-model="input.email" name="email" type="text" class="form-control"
                placeholder="Email or Username" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="mb-3 text-danger">
              <ErrorMessage name="email" />
            </div>

            <div class="input-group">
              <Field v-model="input.password" name="password" type="password" class="form-control"
                placeholder="Password" />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="mb-3 text-danger">
              <ErrorMessage name="password" />
            </div>

            <div class="row">
              <div class="col-8">
                <RouterLink :to="{ name: 'forgot' }">I forgot my password</RouterLink>

              </div>

              <div class="col-4">
                <button v-if="$auth.config.loading" type="submit" class="btn btn-info btn-block" disabled><i
                    class="fas fa-circle-notch fa-spin"></i></button>
                <button v-else type="submit" class="btn btn-info btn-block"
                  :disabled="Object.keys(errors).length != 0">Sign
                  In</button>
              </div>

            </div>
          </Form>
        </div>

      </div>
    </div>



  </div>
</template>

<script setup lang="ts">
type inputInt = {
  email: string
  password: string
}

import { Form, Field, ErrorMessage, configure } from 'vee-validate'
import * as Yup from 'yup'
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '@/store/auth/AuthStore'
import { useRoute } from 'vue-router'

configure({
  validateOnInput: true,
})

const $route = useRoute();
const $auth = useAuthStore();

const schema = Yup.object({
  email: Yup.string().required('Email or Username is Required'),
  password: Yup.string().required('Password is Required')
})

const input = reactive<inputInt>({
  email: '',
  password: '',
});

onMounted(() => {
  input.email = '',
  input.password = ''

  if ($route.query.email) {
    input.email = $route.query.email.toString()
  }
});
</script>

<style scoped>
a {
  color: var(--info)
}
</style>
