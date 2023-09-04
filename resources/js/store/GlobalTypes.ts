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
