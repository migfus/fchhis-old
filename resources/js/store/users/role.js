import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import { $DebugInfo, $Err, $Log } from '@/helpers/debug'

export const useRoleStore = defineStore('role', () => {
  $DebugInfo('RoleStore')
  const content = ref([
    {
      id: 6,
      name: 'Client',
      icon: 'fa-child',
      color: 'success',
    },
    {
      id: 5,
      name: 'Staff',
      icon: 'fa-user-edit',
      color: 'info',
    },
    {
      id: 4,
      name: 'Agent',
      icon: 'fa-handshake',
      color: 'purple',
    },
    {
      id: 3,
      name: 'Manager',
      icon: 'fa-tasks',
      color: 'orange',
    },
    {
      id: 2,
      name: 'Admin',
      icon: 'fa-crown',
      color: 'warning',
    },
    {
      id: 1,
      name: 'Banned',
      icon: 'fa-ban',
      color: 'danger',
    },
    {
      id: 0,
      name: 'Inactive',
      icon: 'fa-moon',
      color: 'secondary',
    },
  ])

  async function RoleGetAPI() {
    try {
      let { data : {data}} = await axios.get('/api/role')
      content.value = data
    }
    catch(e) {
      $Err('RoleGetAPI Err', {e})
    }
  }


  return { content,  RoleGetAPI}
})
