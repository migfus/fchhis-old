import { ref, reactive } from "vue"
import { defineStore } from "pinia"
import { useToast } from "vue-toastification"
import axios from "axios"

type contentInt = {
  ip: string
  token: string
  auth: {
    avatar: string
    created_at: string
    email: string
    id: number
    role: number
    updated_at: string
    username: string
    person: {
      address: string
      address_id: number
      agent_id: number
      bday: string
      bplace_id: number
      client_id: number
      created_at: string
      due_at: string
      fulfilled_at: string
      id: number
      name: string
      or: string
      pay_type_id: number
      plan_id: number
      sex: boolean
      staff_id: number
      updated_at: string
      user_id: number
    }
  }
}
type configInt = {
  loading: boolean
  status: string
  confirm: boolean
}

export const useAuthStore = defineStore("auth/AuthStore", () => {
  const $toast = useToast();

  const token = ref<string>(JSON.parse(localStorage.getItem('token')))
  const content = ref<null | contentInt>(JSON.parse(localStorage.getItem('auth')) || {})
  const config = reactive<configInt>({
    loading: false,
    status: '',
    confirm: false,
  })

  // SECTION API
  async function LoginAPI(input: { email: string, password: string}) {
    config.loading = true
    try{
      let { data: { data }} = await axios.post('/api/login', input)
      content.value = data
      token.value = data.token
      localStorage.setItem('auth', JSON.stringify(data))
      localStorage.setItem('token', JSON.stringify(data.token))
      $toast.success('Successfuly Login!')
      // @ts-ignore
      this.$router.push({ name: 'dashboard'})
    }
    catch(e) {
      console.log('Login Error', {e})
    }
    config.loading = false
  }

  async function RecoveryAPI(input: {email: string}) {
    config.loading = true
    try {
      let { data: { data }} = await axios.post('/api/recovery', input)
      config.status = data
    }
    catch(e) {
      console.log('RecoveryAPI Error', {e})
    }
    config.loading = false
  }

  async function ConfirmRecoveryAPI(input: {code: string}) {
    try {
      let { data: { data }} = await axios.post('/api/recovery-confirm', input)
      config.confirm = data
    }
    catch(e) {
      console.log('ConfirmRecoveryAPI Error', {e})
    }
  }

  type ChangePasswordInputType = {
    newPassword: string
    confirmPassword: string
    code: string
  }
  async function ChangePasswordAPI(input: ChangePasswordInputType) {
    try {
      let { data: { data }} = await axios.post('/api/change-password-recovery', input)
      if(data) {
        // @ts-ignore
        this.$router.push({name: 'login'})
        $toast.success('Successfully changed password')
      }
    }
    catch(e) {
      console.log('ChangePasswordAPI Error', {e})
    }
  }

  // SECTION FUNC
  function Logout() {
    content.value = null
    localStorage.removeItem('auth')
    // @ts-ignore
    this.$router.push({ name: 'login'})
  }

  function UpdateLocalStorage() {
    localStorage.setItem('auth', JSON.stringify(content.value))
  }

  return {
    content,
    config,
    token,

    UpdateLocalStorage,
    ConfirmRecoveryAPI,
    ChangePasswordAPI,
    LoginAPI,
    RecoveryAPI,
    Logout,
  }
});
