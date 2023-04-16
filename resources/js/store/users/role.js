import { reactive, ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

export const useRoleStore = defineStore('role', () => {
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

  return { content}
})
