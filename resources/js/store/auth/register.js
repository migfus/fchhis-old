import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useRegisterStore = defineStore('register', () => {
  const content = ref({

  })
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
      console.log(e)
    }
    config.loading = false
  }

  async function RegisterAPI() {
    config.loading = true
    try {
      let { data: { data}} = await axios.post('/api/register', params)
      console.log({data})
      this.$router.push({ name: 'login', query: {email: params.email}})
    }
    catch(e) {
      console.log({e})
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
