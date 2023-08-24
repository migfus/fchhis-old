import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'

const title = 'users/RoleStore'
export const useRoleStore = defineStore(title, () => {
  // DEBUG Add Type on 'content'
  const content = useStorage(`${title}/content`, [], localStorage)


  // SECTION API
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
