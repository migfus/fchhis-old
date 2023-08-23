import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useStorage, StorageSerializers } from '@vueuse/core'

type paramsInt = {
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

  const params = useStorage<paramsInt>(`${title}/params`, null, localStorage, { serializer: StorageSerializers.object })
  const config = useStorage<{ loading: boolean}>(`${title}/config`, {loading: false}, localStorage, {serializer: StorageSerializers.object })

  // SECTION API
  async function ORAPI() {
    config.value.loading = true
    try {
      let { data: { data}} = await axios.post('/api/or', params)
      if (data) {
        // @ts-ignore
        this.$router.push({ name: "register-fill" });
        Object.assign(params, {
          ...data
        })
      }
    }
    catch(e) {
      $toast.error('Invalid OR Number')
      console.log('OR API ERROR: ' + {e})
    }
    config.value.loading = false
  }

  async function RegisterAPI() {
    config.value.loading = true
    try {
      let { data: { data}} = await axios.post('/api/register', params)
      console.log('Register API', {data})
      $toast.success('Successfully registered')
      // @ts-ignore
      this.$router.push({ name: 'login', query: {email: params.email}})
    }
    catch(e) {
      console.log('Register API', {e})
    }
    config.value.loading = false
  }

  return {
    params,
    config,

    ORAPI,
    RegisterAPI
  }
})
