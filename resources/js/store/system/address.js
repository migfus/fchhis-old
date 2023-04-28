import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'
import {$DebugInfo, $Err} from '@/helpers/debug'

export const useAddressStore = defineStore('address', () => {
  $DebugInfo('AddressStore')

  const content = ref([])

  async function GetAPI() {
    try {
      let { data } = await axios.get('/api/address')
      content.value = data
    }
    catch(e) {
      $Err("Get API Error", {e})
    }
  }

  return { content, GetAPI }
});
