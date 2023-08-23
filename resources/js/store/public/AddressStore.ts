import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers} from '@vueuse/core'

type contentInt = Array<{
  id: number
  name: string
  cities: Array<{
    id: number
    name: string
    zipcode: number
  }>
}>

const title = 'public/AddressStore'

export const useAddressStore = defineStore(title, () => {
  const content = useStorage<contentInt>(`${title}/content`, [], localStorage, { serializer: StorageSerializers.object })

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
