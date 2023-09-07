<template>
    <Form v-slot="{ errors }" :validation-schema="schema" @submit="Update">

        <div class="form-group">
            <label for="new-password">New Password</label>
            <Field v-model="input.newPassword" name="newPassword" type="text" class="form-control" id="new-password"
                placeholder="New Password" :disabled="!can('update', 'auth')" />
            <div class="mb-3 text-danger">
                <ErrorMessage name="newPassword" />
            </div>
        </div>

        <!-- <button v-if="can('update', 'auth')" class="btn btn-info float-right" :disabled="Object.keys(errors).length != 0">
            Change
        </button> -->

        <AppButton @click="$user.config.form = null" icon="fa-times" color="danger" push="right">
            Cancel
        </AppButton>

        <AppButton icon="fa-pen" color="warning" push="right" mr="1">
            Update
        </AppButton>


    </Form>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import * as Yup from 'yup'
import { Form, Field, ErrorMessage, configure, } from 'vee-validate'
import axios from 'axios'
import { useToast } from "vue-toastification"
import { useAbility } from '@casl/vue'
import { useUserDetailsStore } from '@/store/@staff/UserDetailStore';

import AppButton from '@/components/AppButton.vue';

configure({
    validateOnInput: true,
})

const schema = Yup.object({
    currentPassword: Yup.string().required('Current Password Required').min(8, 'Minimum of 8 Characters'),
    newPassword: Yup.string().required('New Password Required').min(8, 'Minimum of 8 Characters'),
    confirmPassword: Yup.string().oneOf([Yup.ref('newPassword'), null], 'Password must match to New Password')
})

const input = reactive({
    currentPassword: '',
    newPassword: '',
    confirmPassword: '',
})

const $props = defineProps(['active', 'id']);
const $toast = useToast();
const { can } = useAbility();
const $user = useUserDetailsStore();

async function Update() {
    try {
        const { data } = await axios.post('/api/change-password', input)
        console.log('UpdateAPI', data.data)
        $toast.success('Successfuly Changed')
        Object.assign(input, { currentPassword: '', newPassword: '', confirmPassword: '' })
    }
    catch (e) {
        console.log('UpdateAPI Err', { e })
        $toast.error('Incorrect Current Password')
    }
}
</script>


