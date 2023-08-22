import { ref, reactive } from 'vue'
import axios from 'axios'
import { defineStore } from 'pinia'

export const usePayTypeStore = defineStore('system/PayTypeStore', () => {
  // DEBUG add type of content
  const content = ref([])
  const config = reactive<{loading: boolean}>({
    loading: false
  })

  async function GetAPI() {
    config.loading = true
    try{
      let { data: { data}} = await axios.get('/api/pay-type')
      content.value = data
    }
    catch(e) {
      console.log("GetAPI Err", {e})
    }
    config.loading = false
  }

  return {
    content,

    GetAPI,
  }
})
