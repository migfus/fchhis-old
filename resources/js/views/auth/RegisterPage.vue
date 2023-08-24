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
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Please Enter OR Number</p>
                    <Form v-slot="{ errors }" :validation-schema="schema" validate-on-mount @submit="$register.ORAPI()">

                        <div class="input-group">
                            <Field v-model="$register.params.or" name="or" type="text" class="form-control"
                                placeholder="YYYYMMDD-XXX" />ChangePasswordInputType
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-arrow-right"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-danger">
                            <ErrorMessage name="or" />
                        </div>

                        <div class="row">
                            <div class="col-8">

                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-info btn-block"
                                    :disabled="Object.keys(errors).length != 0">{{
                                        $register.config.loading ? 'Loading' : 'Register' }}</button>
                            </div>

                        </div>
                    </Form>

                    <p class="mb-1 mt-2">
                        <RouterLink :to="{ name: 'login' }">Back to login</RouterLink>
                    </p>
                </div>

            </div>
        </div>



    </div>
</template>

<script setup lang="ts">
import { Form, Field, ErrorMessage, configure } from 'vee-validate'
import * as Yup from 'yup'
import { onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useRegisterStore } from '@/store/auth/RegisterStore'

configure({
    validateOnInput: true,
})

const $route = useRoute();
const $register = useRegisterStore();

const schema = Yup.object({
    or: Yup.string().required('OR is Required'),
})

onMounted(() => {
    $register.params.or = $route.query.or.toString() || ''
});
</script>

<style scoped>
a {
    color: var(--info)
}
</style>
