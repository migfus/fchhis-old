import { ref } from 'vue'
import { defineStore } from 'pinia'
import axios from 'axios'

type contentInt = Array<{
  id: number
  name: string
  cities: Array<{
    id: number
    name: string
    zipcode: number
  }>
}>

export const useAddressStore = defineStore('public/AddressStore', () => {
  const content = ref<contentInt>([])

  async function GetAPI() {
    try {
      let { data } = await axios.get('/api/public/address')
      content.value = data
    }
    catch(e) {
      console.log("Get API Error", {e})
    }
  }

  return {
    content,

    GetAPI
  }
});
