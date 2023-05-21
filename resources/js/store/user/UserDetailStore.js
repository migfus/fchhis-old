import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import {$DebugInfo, $Err} from '@/helpers/debug'

export const useUserDetailsStore = defineStore('useUserDetailsStore', () => {
  $DebugInfo('useUserDetailsStore')

  const content = ref([])
  const config = reactive({
    loading: false,
  })

  async function GetAPI(id) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/users/'+ id)
      content.value = data
    }
    catch(e) {
      $Err('Get API Error', {e})
    }
    config.loading = false
  }

  return {
    content,
    config,

    GetAPI,
  }
})
