import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig } from '../GlobalTypes'

type IParams = {
    or: string
    email: string
    id: number
    avatar: string
    string: string
    address_id: number
    bplace_id: number
    bday: string
    sex: boolean
    name: string
    mobile: string
    confirmPassword: string
    password: string
    username: string
    address: string
}

const title = 'auth/RegisterStore'

export const useRegisterStore = defineStore(title, () => {
    const $toast = useToast();

    const params = useStorage<IParams>(`${title}/params`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false
    })

    // SECTION API
    async function ORAPI() {
        config.loading = true
        try {
            let { data: { data}} = await axios.post('/api/or', params.value)
            if (data) {
                // @ts-ignore
                this.$router.push({ name: "register-fill" });
                Object.assign(params.value, {
                ...data
                })
            }
        }
        catch(e) {
            $toast.error('Invalid OR Number')
            console.log('OR API ERROR: ' + {e})
        }
        config.loading = false
    }

    async function RegisterAPI() {
        config.loading = true
        try {
            let { data: { data}} = await axios.post('/api/register', params.value)
            console.log('Register API', {data})
            $toast.success('Successfully registered')
            // @ts-ignore
            this.$router.push({ name: 'login', query: {email: params.value.email}})
        }
        catch(e) {
            console.log('Register API', {e})
        }
        config.loading = false
    }

    return {
        params,
        config,

        ORAPI,
        RegisterAPI
    }
})
