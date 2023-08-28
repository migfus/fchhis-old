import { ref, toRaw, reactive } from "vue"
import { defineStore } from "pinia"
import { useToast } from "vue-toastification"
import { useStorage, StorageSerializers } from '@vueuse/core'
import axios from "axios"
import ability from '@/Ability';

type IContent = {
    ip: string
    token: string
    auth: {
        avatar: string
        created_at: string
        email: string
        id: number
        role: number
        updated_at: string
        username: string
        name: string
        // NOTE FOR CLIENTS & AGENTS ONLY
        info?: {
            address: string
            address_id: number
            agent_id: number
            bday: string
            bplace_id: number
            client_id: number
            created_at: string
            due_at: string
            fulfilled_at: string
            id: number
            or: string
            pay_type_id: number
            plan_id: number
            sex: boolean
            staff_id: number
            updated_at: string
            user_id: number
        }
    },
    permissions: Array<String>
    role: string
}
type IConfig = {
    loading: boolean
    status: string
    confirm: boolean
}
type IChangePasswordInput = {
    newPassword: string
    confirmPassword: string
    code: string
}

const title = 'auth/AuthStore'

export const useAuthStore = defineStore(title, () => {
    const $toast = useToast();

    const _token = useStorage<string>(`${title}/token`, null, localStorage);
    const _content = useStorage<IContent>(`${title}/content`, null, localStorage, { serializer: StorageSerializers.object })

    const token = ref(toRaw(_token))
    const content = ref(toRaw(_content))
    const config = reactive<IConfig>({
        loading: false,
        status: '',
        confirm: false,
    })

    // SECTION API
    async function LoginAPI(input: { email: string, password: string}) {
        config.loading = true
        try{
            let { data: { data }} = await axios.post('/api/login', input)
            UpdateData(data)
            token.value = data.token
            _token.value = data.token

            $toast.success('Successfuly Login!')
            // @ts-ignore
            this.$router.push({ name: 'dashboard'})
        }
        catch(e) {
            console.log('Login Error', {e})
        }
        config.loading = false
    }

    async function RecoveryAPI(input: {email: string}) {
        config.loading = true
        try {
            let { data: { data }} = await axios.post('/api/recovery', input)
            config.status = data
        }
        catch(e) {
            console.log('RecoveryAPI Error', {e})
        }
        config.loading = false
    }

    async function ConfirmRecoveryAPI(input: {code: string}) {
        try {
            let { data: { data }} = await axios.post('/api/recovery-confirm', input)
            config.confirm = data
        }
        catch(e) {
            console.log('ConfirmRecoveryAPI Error', {e})
        }
    }

    async function ChangePasswordAPI(input: IChangePasswordInput) {
        try {
            let { data: { data }} = await axios.post('/api/change-password-recovery', input)
            if(data) {
                // @ts-ignore
                this.$router.push({name: 'login'})
                $toast.success('Successfully changed password')
            }
        }
        catch(e) {
            console.log('ChangePasswordAPI Error', {e})
        }
    }

  // SECTION FUNC
    function Logout() {
        content.value = null
        _content.value = null
        token.value = null
        _token.value = null
        // @ts-ignore
        this.$router.push({ name: 'login'})
    }

    function UpdateLocalStorage() {
        _content.value = content.value
    }

    function UpdateData(authData: IContent) {
        content.value = authData
        _content.value = authData

        UpdateAbility()
    }

    function UpdateAbility() {
        if(content.value) {
            ability.update([
                ...content.value.permissions.map((str) => {
                    return {
                        action: str.split(' ')[0],
                        subject: str.split(' ')[1],
                    }
                })
            ])
        }
        else {
            ability.update([
                {
                    action: 'show',
                    subject: 'login',
                }
            ])
        }
    }

    return {
        content,
        config,
        token,

        UpdateLocalStorage,
        ConfirmRecoveryAPI,
        ChangePasswordAPI,
        LoginAPI,
        RecoveryAPI,
        Logout,
        UpdateData,
        UpdateAbility
    }
});
