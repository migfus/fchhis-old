import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log} from '@/helpers/debug'

export const useTransactionStore = defineStore('transactions-clients', () => {
  $DebugInfo('TransactionStore')

  const content = ref([])

  const params = ref({
   ...InitParams()
  })
  const query = reactive({
    search: '',
    limit: 10,
  })
  const config = reactive({
    loading: false,
  })

  function InitParams() {
    return {
      client: {
        person: {
          id: '',
        }
      },
      agent: {
        person: {
          id: '',
        }
      }
    }
  }

  async function GetAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.get(`/api/transactions`, { params: query })
      content.value = data
    }
    catch (e) {
      $Err("Get API", {e})
    }
    config.loading = false
  }

  return {
    content,
    params,
    query,
    config,

    GetAPI,
  }
})
