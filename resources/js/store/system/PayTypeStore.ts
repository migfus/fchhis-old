import axios from 'axios'
import { defineStore } from 'pinia'
import { useStorage, StorageSerializers } from '@vueuse/core'

const title = 'system/PayTypeStore'

export const usePayTypeStore = defineStore(title, () => {
  // DEBUG add type of content
  const content = useStorage(`${title}/content`, [], localStorage, { serializer: StorageSerializers.object })
  const config = useStorage<{loading: boolean}>(`${title}/config`, { loading: false }, localStorage, {serializer: StorageSerializers.object })

  async function GetAPI() {
    config.value.loading = true
    try{
      let { data: { data}} = await axios.get('/api/pay-type')
      content.value = data
    }
    catch(e) {
      console.log("GetAPI Err", {e})
    }
    config.value.loading = false
  }

  return {
    content,

    GetAPI,
  }
})
