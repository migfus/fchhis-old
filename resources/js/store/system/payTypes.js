import { ref, reactive } from 'vue'
import axios from 'axios'
import { defineStore } from 'pinia'
import { $DebugInfo, $Log, $Err} from '@/helpers/debug'

export const usePayTypeStore = defineStore('payType', () => {
  $DebugInfo('PayTypeStore')
  const content = ref([])
  const config = reactive({
    loading: false
  })

  async function GetAPI() {
    config.loading = true
    try{
      let { data: { data}} = await axios.get('/api/pay-type')
      content.value = data
    }
    catch(e) {
      $Err("GetAPI Err", {e})
    }
    config.loading = false
  }

  return {
    content,

    GetAPI,
  }
})
