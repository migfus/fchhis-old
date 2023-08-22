import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'

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

export const useRegisterStore = defineStore('auth/RegisterStore', () => {
  const $toast = useToast();

  const params = reactive<paramsInt>(null)
  const config = reactive({
    loading: false,
  })

  // SECTION API
  async function ORAPI() {
    config.loading = true
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
    config.loading = false
  }

  async function RegisterAPI() {
    config.loading = true
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
    config.loading = false
  }

  return {
    params,
    config,

    ORAPI,
    RegisterAPI
  }
})
