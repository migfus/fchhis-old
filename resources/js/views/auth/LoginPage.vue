<template>
  <div class="mt-5 d-flex justify-content-center">
    <div class="">
      <div class="login-logo">
        <RouterLink :to="{ name: 'home' }">
          <div>
            <img src="/images/logo.png" alt="logo" style="width: 150px;">
          </div>
          <div>Future Care & Helping Hands</div>
          <div>Insurance Service</div>
        </RouterLink>
      </div>

      <div class="card mb-5">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$auth.Login(input)">

            <div class="input-group">
              <Field v-model="input.email" name="email" type="email" class="form-control" placeholder="Email" />
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
                <button type="submit" class="btn btn-info btn-block" :disabled="Object.keys(errors).length != 0">Sign
                  In</button>
              </div>

            </div>
          </Form>
        </div>

      </div>
    </div>



  </div>
</template>

<script setup>
import { Form, Field, ErrorMessage, configure } from 'vee-validate'
import * as Yup from 'yup'
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '../../store/auth/auth'
import { useRoute } from 'vue-router'

configure({
  validateOnInput: true,
})

const $route = useRoute();
const $auth = useAuthStore();

const schema = Yup.object({
  email: Yup.string().required('Email is Required').email('Invalid Email'),
  password: Yup.string().required('Password is Required')
})

const input = reactive({
  email: '',
  password: '',
});

onMounted(() => {
  input.email = 'admin@gmail.com',
    input.password = '12345678'

  if ($route.query.email) {
    input.email = $route.query.email
  }
});
</script>

<style scoped>
a {
  color: var(--info)
}
</style>
