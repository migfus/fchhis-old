import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'
import axios from 'axios'

export const useUserDetailsStore = defineStore('user-details', () => {
  $DebugInfo('UserDetailsStore')
  const content = ref(false)
  const config = reactive({
    loading: false,
  })

  async function GetAPI(id) {
    config.loading = true
    try {
      let { data: { data}} = await axios.get('/api/users/'+id)
      content.value = data
    }
    catch(e) {
      $Err('User Details GetAPI', {e})
    }
    config.loading = false
  }

  return {
    content,
    config,

    GetAPI,
  }
})
