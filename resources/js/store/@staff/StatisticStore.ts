import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'
import { reactive } from 'vue'
import type { TGConfig } from '../GlobalTypes'

type IContent = {
    agents: {
        current: number
        total: number
    }
    beneficiaries: {
        current: number
        total: number
    }
    total: {
        current: number
        total: number
    }
    clients: {
        current: number
        total: number
    }
    transactions: {
        current: number
        total: number
    }
    deceased: {
        current: number
        total: number
    }
}

const title = '@staff/StatisticStore'

export const useStatisticStore = defineStore(title, () => {
    const CancelToken = axios.CancelToken;
    let cancel;

    // DEBUG please fill type of 'content'
    const content = useStorage<IContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
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
