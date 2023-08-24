import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'

const title = 'users/AgentStore'

export const useAgentStore = defineStore(title, () => {
  // DEBUG Add type on 'content'
  const content = useStorage(`${title}/content`, [], localStorage)
  const config = useStorage<{loading: boolean}>(`${title}/config`, {
    loading: false,
  }, localStorage, { serializer: StorageSerializers.object })


  // SECTION API
  async function GetAPI() {
    config.value.loading = true
    try {
      let { data: {data}} = await axios.get('/api/agent')
      content.value = data
    }
    catch(e) {
      console.log('Get API Error', {e})
    }
    config.value.loading = false
  }

  return {
    content,
    config,

    GetAPI,
  }
})
