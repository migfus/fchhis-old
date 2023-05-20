import { ref, reactive } from "vue";
import { defineStore } from "pinia";
import { useToast } from "vue-toastification";
import axios from "axios";
import { $Err, $DebugInfo} from '@/helpers/debug'

export const useAuthStore = defineStore("auth", () => {
  $DebugInfo('AuthStore');

  const $toast = useToast();

  const token = ref(JSON.parse(localStorage.getItem('token')) || '')
  const content = ref(JSON.parse(localStorage.getItem('auth')) || {
    auth: {
      role: false
    },
    token: false,
    ip: false,
  })
  const config = reactive({
    loading: false,
    status: false,
    confirm: false,
  })

  // SECTION API
  async function LoginAPI(input) {
    config.loading = true
    try{
      let { data: { data }} = await axios.post('/api/login', input)
      content.value = data
      token.value = data.token
      localStorage.setItem('auth', JSON.stringify(data))
      localStorage.setItem('token', JSON.stringify(data.token))
      $toast.success('Successfuly Login!')
      this.$router.push({ name: 'dashboard'})
    }
    catch(e) {
      $Err('Login Error', {e})
    }
    config.loading = false
  }

  async function RecoveryAPI(input) {
    config.loading = true
    try {
      let { data: { data }} = await axios.post('/api/recovery', input)
      config.status = data
    }
    catch(e) {
      $Err('RecoveryAPI Error', {e})
    }
    config.loading = false
  }

  async function ConfirmRecoveryAPI(input) {
    try {
      let { data: { data }} = await axios.post('/api/recovery-confirm', input)
      config.confirm = data
    }
    catch(e) {
      $Err('ConfirmRecoveryAPI Error', {e})
    }
  }

  async function ChangePasswordAPI(input) {
    try {
      let { data: { data }} = await axios.post('/api/change-password-recovery', input)
      if(data) {
        this.$router.push({name: 'login'})
        $toast.success('Successfully changed password')
      }
    }
    catch(e) {
      $Err('ChangePasswordAPI Error', {e})
    }
  }

  // SECTION FUNC
  function Logout() {
    content.value = null
    localStorage.removeItem('auth')
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
