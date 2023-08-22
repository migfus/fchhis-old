import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useUserDetailsStore = defineStore('user/UserDetailStore', () => {

  // DEBUG Add type for 'content'
  const content = ref([])
  const config = reactive<{loading: boolean}>({
    loading: false,
  })

  async function GetAPI(id: bigint) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/users/'+ id)
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
