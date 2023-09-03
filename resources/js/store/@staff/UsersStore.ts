import { useStorage, StorageSerializers } from '@vueuse/core'
import { defineStore } from 'pinia'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { reactive, ref } from 'vue'
import { PrintTest } from '@/helpers/print'
import { useAddressStore } from '@/store/public/AddressStore'
import moment from 'moment'
import { useAuthStore } from '@/store/auth/AuthStore'

type IConfig = {
    loading: boolean
    notify: boolean
    form: string
    tableView: boolean
    viewAll: boolean
    RemoveNotify: boolean
}
type IQuery = {
    search: string
    sort: 'ASC' | 'DESC'
    limit: number
    start: string
    end: string
    filter: string
    role: number
    overdue: boolean
}
type IParams = {
    avatar: string
    username: string
    email: string
    password: string
    role: number
    plan: number
    pay_type_id: number
    transaction: number,
    agent_id: string
    mobile: string
    name: string
    sex: boolean
    bday: string
    bplace_id: number
    address: string
    address_id: number
    or: string
    agent: number
    plan_id: number
    id: number
    phones?: Array<{phone: string}>
}
type TContent = {
    data: Array<{
        id: number
        avatar: string
        branch_id: number
        client_transactions_sum_amount: number
        created_at: string
        email: string
        name: string
        username: string
        info: {
            address: string
            address_id: bigint
            bday: string
            bplace_id: BigInteger
            due_at: string
            agent: {
                name: string
                avatar: string
            }
            pay_type: {
                name: string
            }
            staff: {
                name: string
                avatar: string
            }
            plan: {
                id: string
                name: string
            }
        }
    }>
}

const title = '@staff/UsersStore'

export const useUsersStore = defineStore(title, () => {
    const $toast = useToast();
    const $address = useAddressStore();
    const $auth = useAuthStore();
    const CancelToken = axios.CancelToken;
    let cancel;

    // DEBUG ADd type on 'print'
    const content = ref<TContent>(null)
    const contentReport = ref<any>(null)
    const print = useStorage(`${title}/print`, null, localStorage)
    const config = reactive<IConfig>({
        loading: false,
        notify: true,
        form: '',
        tableView: false,
        viewAll: false,
        RemoveNotify: false
    })
    const query = reactive<IQuery>({
        search: '',
        sort: 'ASC',
        limit: 10,
        start: '',
        end: '',
        filter: 'name',
        role: 6,
        overdue: false
    })
    const params = useStorage<IParams>(`${title}/params`, {
        ...InitParams(),

    }, localStorage, { serializer: StorageSerializers.object })

    // SECTION API
    async function GetAPI(page = 1) {
        config.loading = true
        try {
            let { data: {data}} = await axios.get('/api/users', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query, page: page}
            })
            content.value = data
        }
        catch(e) {
            console.log('UsersStore GetAPI Error', {e})
        }
        config.loading = false
    }

    async function PrintAPI() {
        try {
            let { data: {data}} = await axios.get<TContent>('/api/users', {
                cancelToken: new CancelToken(function executor(c) { cancel = c; }),
                params: { ...query, print: true }
            })
            contentReport.value = data.map(el => {
                return [
                    el.id,
                    el.name,
                    el.username,
                    el.email,
                    el.info.plan.name,
                    el.info.pay_type.name,
                    `${el.info.address}, ${$address.CityIDToFullAddress(el.info.address_id)}`,
                    el.client_transactions_sum_amount ?? 0,
                    el.client_transactions_sum_amount ?? 0,
                    el.info.due_at,
                    el.info.agent.name,
                    el.info.staff.name,
                    moment(el.created_at).format('MM/DD/YYYY hh:mm A'),
                ]
            })
            console.log(contentReport.value)
            PrintTest(contentReport.value, $auth.content.auth.name, query.start, query.end)
        }
        catch(e) {
            console.log('UsersStore PrintAPI Error', {e})
        }
    }

    function CancelAPI() {
        cancel()
        content.value = null
    }

    async function StoreAPI() {
        try {
            let { data: { data }} = await axios.post('/api/users', params.value)
            Object.assign(params.value, {... InitParams()})
            $toast.success('Successfully created');
            GetAPI(1)
            ChangeForm('')
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    async function UpdateAPI(id) {
        try {
            let { data: { data }} = await axios.put('/api/users/'+id, params.value)
            Object.assign(params.value, {... InitParams()})
            $toast.success('Successfully created');
            GetAPI(1)
            ChangeForm('')
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    async function DestroyAPI(id) {
        try {
            let { data: { data }} = await axios.delete('/api/users/'+ id)
            $toast.success('Successfully deleted');
            GetAPI(1)
        }
        catch(e) {
            console.log('UsersTore SToreAPI Error', {e})
        }
    }

    // SECTION FUNCTIONS
    function ChangeForm(input) {
        config.form = input
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth',
        })
    }



    function InitParams() {
        return {
            avatar: '',
            username: '',
            email: '',
            password: '',
            role: 6,
            plan: 1,
            pay_type_id: 1,
            transaction: 0,
            agent_id: '',
            mobile: '',
            name: '',
            sex: true,
            bday: '',
            bplace_id: 0,
            address: '',
            address_id: 0,
            or: '',
            phones: null,
            agent: 0,
            plan_id: 0,
            id: 0
        }
    }

    function Update(row) {
        Object.assign(params.value, row)

        config.form = 'update'

        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'smooth'
        });
    }

    return {
        content,
        contentReport,
        config,
        query,
        print,
        params,

        GetAPI,
        PrintAPI,
        CancelAPI,
        StoreAPI,
        UpdateAPI,
        DestroyAPI,

        ChangeForm,
        Update,
    }
})
