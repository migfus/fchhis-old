import { ref, reactive} from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'


export const useDownHeadStore = defineStore('downhead', () => {
  const content = ref(null)
  const query = reactive({
    search: '',
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
      console.log({e})
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
