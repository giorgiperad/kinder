import checkoutFormModel from './checkoutFormModel';

const {
  formField: {
    municipality,
    gardenName,
    group,
    kidsId,
    kidsFirstName,
    kidsLastName,
    mothersId,
    mothersFirstName,
    mothersLastName,
    fathersId,
    fathersFirstName,
    fathersLastName,
    mobileNumber,
    email
  }
} = checkoutFormModel;

export default {
  [municipality.name]: '',
  [gardenName.name]: '',
  [group.name]: '',
  [kidsId.name]: '',
  [kidsFirstName.name]: '',
  [kidsLastName.name]: '',
  [mothersId.name]: '',
  [mothersFirstName.name]: '',
  [mothersLastName.name]: '',
  [fathersId.name]: '',
  [fathersFirstName.name]: '',
  [fathersLastName.name]: '',
  [mobileNumber.name]: '',
  [email.name]: ''
};




