import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

type contentInt = {
  overdue: string
  grace: string
}

export const useOverdueStore = defineStore('users/OverdueStore', () => {
  // DEBUG Add Type on 'content'

  const content = ref<contentInt>([])
  const config = reactive<{loading: boolean}>({
    loading: false,
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/overdue')
      content.value = data
    }
    catch(e) {
      console.log('Get API Error', {e})
    }
    config.loading = false
  }

  return {
    content,
    config,

    GetAPI,
  }
})
