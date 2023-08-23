import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'

type contentInt = {
  overdue: string
  grace: string
}

const title = 'users/OverdueStore'

export const useOverdueStore = defineStore(title, () => {
  // DEBUG Add Type on 'content'

  const content = useStorage<contentInt>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
  const config = useStorage<{loading: boolean}>(`${title}/config`, {
    loading: false,
  }, localStorage, { serializer: StorageSerializers.object })

  async function GetAPI() {
    config.value.loading = true
    try {
      let { data: {data}} = await axios.get('/api/overdue')
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
