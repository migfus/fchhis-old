// SECTION auth/AuthStore

export type authConfigInt = {
  loading: boolean;
  status: string;
  confirm: boolean;
}


export type TPlanDetails = {
    plan: { name: string }
    monthly: number,
    quarterly: number,
    semi_annual: number,
    annual: number,
    spot_pay: number,
    spot_service: number,
}

export type TPayType = {
    name: string
}

export type TAuthContent = {
    branch_id: bigint
    branch: {
        name: string
    }

    region_id: bigint
    region: {
        name: string
    }

    avatar: string
    created_at: dateFns
    email: string
    id: bigint
    role: string //DEBUG UNSORE
    name: string
    info?: TUserInfo
}

type TUserInfo = {
    staff_id: bigint
    staff: {
        name: string
    }

    agent_id: bigint
    agent: {
        name: string
    }

    pay_type_id: bigint
    pay_type: TPayType

    plan_details_id: bigint
    plan_details: TPlanDetails

    bday: dateFns
    bplace_id: bigint
    sex: boolean
    address_id: bigint
    address: string
    due_at?: bigint // null = no due
    fulfilled_at?: dateFns // null = not claimed
    or?: string // null = no initial OR number
}

export type TGConfig = {
    loading: boolean
    form?: string
}

export type TGQuery = {
    search: string
    filter?: string
    sort: 'ASC' | 'DESC'
    start?: Date
    end?: Date
}

export type TGAddress = {
    id: number
    name: string
    cities: Array<{
        id: number
        name: string
        zipcode: number
    }>
}
