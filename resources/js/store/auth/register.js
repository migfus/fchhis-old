import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log} from '@/helpers/debug'

export const useRegisterStore = defineStore('register', () => {
  $DebugInfo("RegisterStore")

  const content = ref({})
  const params = reactive({
    or: '',
  })
  const config = reactive({
    loading: false,
  })

  async function ORAPI() {
    config.loading = true
    try {
      let { data: { data}} = await axios.post('/api/or', params)
      if (data) {
        this.$router.push({ name: "register-fill" });
        Object.assign(params, {
          ...data,
          notifyMobile: true
        })
      }
    }
    catch(e) {
      $Err('OR API ERROR: ' + {e})
    }
    config.loading = false
  }

  async function RegisterAPI() {
    config.loading = true
    try {
      let { data: { data}} = await axios.post('/api/register', params)
      $Log('Register API', {data})
      this.$router.push({ name: 'login', query: {email: params.email}})
    }
    catch(e) {
      $Err('Register API', {e})
    }
    config.loading = false
  }

  return {
    content,
    params,
    config,

    ORAPI,
    RegisterAPI
  }
})
