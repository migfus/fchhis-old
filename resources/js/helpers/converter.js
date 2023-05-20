import moment from 'moment'
import { useAddressStore } from '@/store/system/address';

const $address = useAddressStore();

export const RoleToDesc = (id) => {
  switch (id) {
    case 0:
      return "Inactive";
    case 1:
      return "Beneficiary";
    case 2:
      return "Admin";
    case 3:
      return "Manager";
    case 4:
      return "Agent";
    case 5:
      return "Staff";
    case 6:
      return "Client";
    default:
      return "Banned";
  }
};

export const RoleToID = (id) => {
  switch (id) {
    case "Inactive":
      return 0;
    case "Banned":
      return 1;
    case "Admin":
      return 2;
    case "Manager":
      return 3;
    case "Agent":
      return 4;
    case "Staff":
      return 5;
    case "Client":
      return 6;
    default:
      return "Banned";
  }
};

export const AgeConverter = (bday) => {
  return moment().diff(bday, 'years');
}

export const NumberAddComma = (num)  => {
  if(num) {
    num = Number(num).toFixed(2);
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  return '0.00'
}

// SECTION ADDRESS
export const CityIDToDesc = (id) => {
  for (let i = 0; $address.content.length > i; i++) {
    const { cities } = $address.content[i];
    for (let f = 0; cities.length > f; f++) {
      if (cities[f].id == id) {
        return cities[f].name;
      }
    }
  }
  return null;
};

export const ProvinceIDToDesc = (id) => {
  for (let i = 0; $address.content.length > i; i++) {
    const province = $address.content[i];
    for (let f = 0; province.cities.length > f; f++) {
      if (province.cities[f].id == id) {
        return province.name;
      }
    }
  }
  return null;
};

export const CityIDToFullAddress = (id) => {
  for (let i = 0; $address.content.length > i; i++) {
    const province = $address.content[i];
    for (let f = 0; province.cities.length > f; f++) {
      if (province.cities[f].id == id) {
        return `${province.cities[f].name}, ${province.name}`;
      }
    }
  }
  return null;
};

export const CityIDToProvinceID = (id) => {
  for (let i = 0; $address.content.length > i; i++) {
    const province = $address.content[i];
    for (let f = 0; province.cities.length > f; f++) {
      if (province.cities[f].id == id) {
        return province.id;
      }
    }
  }
  return null;
};

export const GetPercentage = (num1, num2) => {
  return (((num1 - num2) / num1) * 100).toFixed(2);
}

export const PlanToAmount = (pay_type_id, plan) => {
  switch (pay_type_id) {
    case 1:
      return plan.monthly
    case 2:
      return plan.querterly
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

export const PlanToPay = (pay_type, plan) => {
  switch (pay_type.name) {
    case 'Monthly':
      return plan.monthly * 60
    case 'Quarterly':
      return plan.querterly * 24
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

export const Sum = (items, prop) => {
  return items.reduce( function(a, b){
      return Number(a) + Number(b[prop]);
  }, 0);
}
