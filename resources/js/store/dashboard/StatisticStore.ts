import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig } from '../GlobalTypes'

const title = 'dashboard/StatisticStore'

export const useStatisticStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    // DEBUG please fill type of 'content'
    const content = useStorage(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = reactive<TGConfig>({
        loading: false
    })

  // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/statistic', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; })
            })
            content.value = data
        }
        catch(e) {
            console.log('StatisticStore GetAPI Error', {e})
        }
        config.loading = false
    }

    function CancelAPI() {
        cancel()
        content.value = null
    }

    return {
        content,
        config,

        GetAPI,
        CancelAPI,
    }
})
