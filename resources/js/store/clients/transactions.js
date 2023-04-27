import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useTransactionStore = defineStore('transactions-clients', () => {
  const content = ref(false)
  const params = ref({
   ...InitParams()
  })
  const query = reactive({
    search: '',
    limit: 10,
  })
  const config = reactive({
    loading: false,
  })

  function InitParams() {
    return {
    }
  }

  async function GetAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.get(`/api/transactions`, { params: query })
      content.value = data
    }
    catch (e) {
      console.log({ e })
    }
    config.loading = false
  }

  return {
    content,
    params,
    query,
    config,

    GetAPI,
  }
})
