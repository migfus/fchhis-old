import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'

const title = 'user/UserDetailsStore'

export const useUserDetailsStore = defineStore(title, () => {

    // DEBUG Add type for 'content'
    const content = useStorage(`${title}/content`, [], localStorage)
    const config = reactive<{loading: boolean}>({
        loading: false,
    })

    // SECTION API
    async function GetAPI(id: bigint) {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users/'+ id)
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
