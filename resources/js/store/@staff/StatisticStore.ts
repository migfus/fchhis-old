import { defineStore } from 'pinia'
import axios from 'axios'
import { useStorage, StorageSerializers } from '@vueuse/core'

type contentIn = {
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
    const content = useStorage<contentIn>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })
    const config = useStorage<{loading: boolean}>(`${title}/config`, { loading: false }, localStorage, { serializer: StorageSerializers.object })

  // SECTION API
    async function GetAPI() {
        config.value.loading = true
        try {
            let { data: {data}} = await axios.get('/api/statictic', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; })
            })
            content.value = data
        }
        catch(e) {
            console.log('StatisticStore GetAPI Error', {e})
        }
        config.value.loading = false
    }

    function CancelAPI() {
        cancel()
    }

    return {
        content,
        config,

        GetAPI,
        CancelAPI,
    }
})
