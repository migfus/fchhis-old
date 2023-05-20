import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'

export const useStatisticStore = defineStore('statisticStore', () => {
  $DebugInfo('useStatisticStore')
  const CancelToken = axios.CancelToken;
  let cancel;

  const content = ref(null)
  const config = reactive({
    loading: false
  })

  // SECTION API
  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/statictics', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; })
      })
      content.value = data
    }
    catch(e) {
      $Err('StatisticStore GetAPI Error', {e})
    }
    config.loading = false
  }

  function CancelAPI() {
    cancel()
  }

  return {
    content,
    config,

    GetAPI,
    CancelAPI,
  }
})
