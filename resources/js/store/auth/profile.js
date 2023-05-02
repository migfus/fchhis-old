import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Log, $Err} from '@/helpers/debug'

export const useProfileStore = defineStore('profile', () => {
  $DebugInfo('ProfileStore')
  const content = ref({})
  const config = reactive({
    loading: false
  })

  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/profile')
      content.value = data
    }
    catch( e) {
      $Err("GetAPI Err", {e})
    }
    config.loading = false

  }
  return {content, GetAPI}
})
