import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useTransactionStore = defineStore('transaction', () => {
  const content = ref([])
  const config = reactive({
    loading: false,
    viewAll: false,
  })
  const params = reactive ({
    search: '',
    filter: '',
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data }} = await axios.get('/api/transactions')
      content.value = data
    }
    catch(e) {
      console.log({e})
    }
    config.loading = false
  }

  function Update() {

  }

  function Delete() {

  }

  return {
    content,
    config,
    params,

    GetAPI,
    Update,
    Delete,
  }
})
