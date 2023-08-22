import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useRoleStore = defineStore('users/RoleStore', () => {
  // DEBUG Add Type on 'content'
  const content = ref([])

  async function GetAPI() {
    try {
      let { data : {data}} = await axios.get('/api/role')
      content.value = data
    }
    catch(e) {
      console.log('RoleGetAPI Err', {e})
    }
  }

  return {
    content,
    GetAPI
  }
})
