import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import { $DebugInfo, $Err} from '@/helpers/debug'
import axios from 'axios'

export const useTransactionStore = defineStore('TransactionStore', () => {
  $DebugInfo('TransactionStore')
  const CancelToken = axios.CancelToken;
  let cancel;

  const content = ref(null)
  const config = reactive({
    loading: false
  })
  const query = reactive({
    search: '',
    sort: 'ASC',
  })

  // SECTION API
  async function GetAPI(page = 1) {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/transaction', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; }),
        params: { ...query, page: page}
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
    query,

    GetAPI,
    CancelAPI,
  }
})
