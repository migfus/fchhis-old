import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import {$DebugInfo, $Err} from '@/helpers/debug'

export const useOverdueStore = defineStore('overdue', () => {
  $DebugInfo('useOverdueStore')

  const content = ref([])
  const config = reactive({
    loading: false,
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/overdue')
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
