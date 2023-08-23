import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'

const title = 'user/UserDetailsStore'

export const useUserDetailsStore = defineStore(title, () => {

  // DEBUG Add type for 'content'
  const content = useStorage(`${title}/content`, [], localStorage)
  const config = useStorage<{loading: boolean}>(`${title}/config`, {
    loading: false,
  }, localStorage, { serializer: StorageSerializers.object })

  async function GetAPI(id: bigint) {
    config.value.loading = true
    try {
      let { data: {data}} = await axios.get('/api/users/'+ id)
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
