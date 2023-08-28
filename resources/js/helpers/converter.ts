import moment from 'moment'

export const RoleToDesc = (id: string) : string => {
    // alert(id)
    switch (id) {
        case '569921868309888':
            return "Admin";
        case '569914608193917':
            return "Regional Manager";
        case '569914608859162':
            return "Branch Manager";
        case '569913882200121':
            return "Staff";
        case '569914152489794':
            return "Agent";
        case '569913882189963':
            return "Client";
        default:
            return "";
    }
};

export const AgeConverter = (bday: Date) => bday == null ? null : moment().diff(bday, 'years');

export const NumberAddComma = (num: number)  => {
    if(num) {
        let _num = Number(num).toFixed(2);
        return _num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    return '0.00'
}

export const GetPercentage = (num1: number, num2: number) => {
    if(num1 && num2) {
        return (((num1 - num2) / num1) * 100).toFixed(2);
    }
    return null
}

type PlanInt = {
    monthly: number,
    quarterly: number,
    semi_annual: number,
    annual: number,
    spot_pay: number,
    spot_service: number,
}

export const PlanToAmount = (pay_type_id: number, plan: PlanInt) => {
    switch (pay_type_id) {
        case 1:
            return plan.monthly
        case 2:
            return plan.quarterly
        case 3:
            return plan.semi_annual
        case 4:
            return plan.annual
        case 5:
            return plan.spot_pay
        case 6:
            return plan.spot_service
        default:
            return 0
    }
}

export const PlanToPay = (pay_type: {name: string}, plan: PlanInt) => {
    switch (pay_type.name) {
        case 'Monthly':
            return plan.monthly * 60
        case 'Quarterly':
            return plan.quarterly * 24
        case 'Semi-Annual':
            return plan.semi_annual * 12
        case 'Annual':
            return plan.annual * 6
        case 'Spot Payment':
            return plan.spot_pay
        case 'Spot Service':
            return plan.spot_service
        default:
            return 0
    }
}

export const Sum = (items, prop: number) => {
    if(prop && items) {
        return items.reduce( function(a, b){
            return Number(a) + Number(b[prop]);
        }, 0);
    }
    return null
}

export const Plural = (name: string, value: number) => {
    if(value > 1) {
        return `${name}s`
    }
    else {
        return `${name}`
    }
}
