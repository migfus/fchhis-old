import { ref, reactive} from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err} from '@/helpers/debug'

export const useDownHeadStore = defineStore('downhead', () => {
  $DebugInfo("DownHeadStore")

  const content = ref(null)
  const query = reactive({
    search: '',
    start: '',
    end: '',
  })
  const config = reactive({
    loading: false,
    form: '',
  })
  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/downhead', { params: query })
      content.value = data
    }
    catch(e) {
      $Err("GetAPI Err", {e})
    }
    config.loading = false
  }

  return {
    content,
    query,
    config,

    GetAPI,
  }
})
