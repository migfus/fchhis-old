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
  })

  async function Login(input) {
    config.loading = true
    try{
      let { data: { data}} = await axios.post('/api/login', input)
      content.value = data
      token.value = data.token
      localStorage.setItem('auth', JSON.stringify(data))
      $toast.success('Successfuly Login!')
      this.$router.push({ name: 'dashboard'})
    }
    catch(e) {
      $Err('Login Error', {e})
    }
    config.loading = false
  }

  function Logout() {
    content.value = {
      auht: { role: false}
    }
    localStorage.removeItem('auth')
    this.$router.push({ name: 'login'})
  }

  function UpdateLocalStorage() {
    console.log(content.value)
    // localStorage.setItem('auth', JSON.stringify(content.value))
  }

  return {
    content,
    config,

    UpdateLocalStorage,
    Login,
    Logout,
  }
});
