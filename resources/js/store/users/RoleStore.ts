import { useStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { reactive } from 'vue'

const title = 'users/RoleStore'
export const useRoleStore = defineStore(title, () => {
    // DEBUG Add Type on 'content'
    const content = useStorage(`${title}/content`, [], localStorage)
    const config = reactive<{ loading: boolean}>({loading: false})


    // SECTION API
    async function GetAPI() {
        config.loading = true
        try {
            let { data : {data}} = await axios.get('/api/role')
            content.value = data
        }
        catch(e) {
            console.log('RoleGetAPI Err', {e})
        }
        config.loading = false
    }

    return {
        content,
        GetAPI
    }
})
