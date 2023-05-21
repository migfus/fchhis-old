import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

export const useRoleStore = defineStore('role', () => {
  $DebugInfo('RoleStore')
  const content = ref([])

  async function GetAPI() {
    try {
      let { data : {data}} = await axios.get('/api/role')
      content.value = data

    }
    catch(e) {
      $Err('RoleGetAPI Err', {e})
    }
  }


  return {
    content,

    GetAPI
  }
})
