import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log} from '@/helpers/debug'

export const useClientStore = defineStore('clients', () => {
  $DebugInfo("ClientStore")

  const content = ref(false)
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
    }
  }

  async function GetAPI() {
    config.loading = true
    try {
      let { data: { data } } = await axios.get(`/api/client`, { params: query })
      content.value = data
    }
    catch (e) {
      $Err("GEt API Error", {e})
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
