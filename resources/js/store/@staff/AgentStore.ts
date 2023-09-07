import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig } from '@/store/GlobalTypes'

const title = '@staff/AgentStore'

export const useAgentStore = defineStore(title, () => {
    // DEBUG Add type on 'content'
    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false,
    })

    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/agent')
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
