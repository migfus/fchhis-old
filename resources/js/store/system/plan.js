import { ref, reactive } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const usePlanStore = defineStore('plan', ()=> {
  const content = ref([])
  const count = ref([])
  const config = reactive({
    loading: false,
    loadingCount: false,
    notify: false,
  })
  const params = reactive({
    search: '',
    filter: 'name',
  })

  async function GetAPI() {
    config.loading = true
    try {
      let { data: {data}} = await axios.get('/api/plan', { params: params});
      content.value = data
    }
    catch(e) {
      console.log({e})
    }
    config.loading = false
  }

  async function GetCount() {
    config.loadingCount = true
    try {
      let { data: {data}} = await axios.get('/api/plan', { params: { count: true}});
      count.value = data
    }
    catch(e) {
      console.log({e})
    }
    config.loadingCount = false
  }

  function RemoveNotify() {
    config.notify = true
  }

  return { content, count, config, params, GetAPI, GetCount, RemoveNotify}
})
