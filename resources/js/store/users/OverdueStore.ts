import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

type IContent = {
    overdue: string
    grace: string
}

const title = 'users/OverdueStore'

export const useOverdueStore = defineStore(title, () => {
  // DEBUG Add Type on 'content'

    const content = useStorage<IContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<{loading: boolean}>({
        loading: false,
    })


    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/overdue')
            content.value = data
        }
        catch(e) {
            console.log('Get API Error', {e})
        }
        config.loading = false
    }

    return {
        content,
        config,

        GetAPI,
    }
})
