import axios from 'axios'
import { defineStore } from 'pinia'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

const title = 'system/PayTypeStore'

export const usePayTypeStore = defineStore(title, () => {
    // DEBUG add type of content
    const content = useStorage(`${title}/content`, [], localStorage, { serializer: StorageSerializers.object })
    const config = reactive<{loading: boolean}>({
        loading: false
    })

    async function GetAPI() {
        config.loading = true
        try{
            let { data: { data}} = await axios.get('/api/pay-type')
            content.value = data
        }
        catch(e) {
            console.log("GetAPI Err", {e})
        }
        config.loading = false
    }

    return {
        content,

        GetAPI,
    }
})
