import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useStatisticStore = defineStore('dashboard/statisticStore', () => {
  const CancelToken = axios.CancelToken;
  let cancel;

  // DEBUG please fill type of 'content'
  const content = ref(null)
  const config = reactive<{loading: boolean}>({
    loading: false
  })

  // SECTION API
  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/statictic', {
        cancelToken: new CancelToken(function executor(c) { cancel = c; })
      })
      content.value = data
    }
    catch(e) {
      console.log('StatisticStore GetAPI Error', {e})
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
