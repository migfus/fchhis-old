import moment from 'moment'

export const RoleToDesc = (id) => {
  switch (id) {
    case 0:
      return "Inactive";
    case 1:
      return "Banned";
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

export const FullNameConvert = (last, first, mid, ext) => {
  return `${last}, ${first} ${mid.charAt(0)}.`
}

export const AgeConverter = (bday) => {
  return moment().diff(bday, 'years');
}
