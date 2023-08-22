import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useAgentStore = defineStore('users/AgentStore', () => {
  // DEBUG Add type on 'content'
  const content = ref([])
  const config = reactive<{loading: boolean}>({
    loading: false,
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/agent')
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
