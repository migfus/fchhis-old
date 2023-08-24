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

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">We will send you a link for password recovery</p>
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount
                        @submit="$auth.RecoveryAPI(input)">

                        <div class="input-group">
                            <Field v-model="input.email" name="email" type="email" class="form-control"
                                placeholder="Email" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-danger">
                            <div v-if="$auth.config.status == 'error'">This email is not registered.</div>
                            <div v-if="$auth.config.status == 'success'" class="text-success">Link Sent! Please check your
                                email.</div>
                            <ErrorMessage name="email" />
                        </div>

                        <div class="row">
                            <div class="col-8">

                            </div>

                            <div class="col-12">
                                <button v-if="$auth.config.loading" class="btn btn-info btn-block" disabled><i
                                        class="fas fa-circle-notch fa-spin"></i></button>
                                <button v-else type="submit" class="btn btn-info btn-block"
                                    :disabled="Object.keys(errors).length != 0">Send
                                    Recovery</button>
                            </div>

                        </div>
                    </Form>

                    <p class="mb-1 mt-2">
                        <RouterLink :to="{ name: 'login' }">Back to login</RouterLink>
                    </p>
                </div>

            </div> <!-- SECTION LOGO -->
        </div>



    </div>
</template>

<script setup lang='ts'>
import { Form, Field, ErrorMessage, configure } from 'vee-validate'
import * as Yup from 'yup'
import { reactive, onMounted } from 'vue'
import { useAuthStore } from '@/store/auth/AuthStore'

configure({
    validateOnInput: true,
})

const $auth = useAuthStore();

const schema = Yup.object({
    email: Yup.string().required('Email is Required').email('Invalid Email'),
})

const input = reactive({
    email: '',
});

onMounted(() => {
    input.email = ''
});
</script>

<style scoped>
a {
    color: var(--info)
}</style>
