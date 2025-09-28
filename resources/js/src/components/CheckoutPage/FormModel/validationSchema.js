import * as Yup from 'yup';
import moment from 'moment';
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

const visaRegEx = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;


export default [
  Yup.object().shape({
    [municipality.name]: Yup.string().required(`${municipality.requiredErrorMsg}`),
    [gardenName.name]: Yup.string().required(`${gardenName.requiredErrorMsg}`),
    [group.name]: Yup.string().required(`${group.requiredErrorMsg}`) //,

    // [firstName.name]: Yup.string().required(`${firstName.requiredErrorMsg}`),
    // [lastName.name]: Yup.string().required(`${lastName.requiredErrorMsg}`),
    // [address1.name]: Yup.string().required(`${address1.requiredErrorMsg}`),
    // [city.name]: Yup.string()
    //   .nullable()
    //   .required(`${city.requiredErrorMsg}`),
    // [zipcode.name]: Yup.string()
    //   .required(`${zipcode.requiredErrorMsg}`)
    //   .test(
    //     'len',
    //     `${zipcode.invalidErrorMsg}`,
    //     val => val && val.length === 5
    //   ),
    // [country.name]: Yup.string()
    //   .nullable()
    //   .required(`${country.requiredErrorMsg}`)
  }),
  Yup.object().shape({
    [kidsId.name]: Yup.string().required(`${kidsId.requiredErrorMsg}`).test(
        'len',
        `${kidsId.legthErrorMsg}`,
        val => val && val.length === 11
      ),
    [kidsFirstName.name]: Yup.string().required(`${kidsFirstName.requiredErrorMsg}`),
    [kidsLastName.name]: Yup.string().required(`${kidsLastName.requiredErrorMsg}`)
  }),
  Yup.object().shape({
    [mothersId.name]: Yup.string().required(`${mothersId.requiredErrorMsg}`).test(
        'len',
        `${mothersId.legthErrorMsg}`,
        val => val && val.length === 11
      ),
    [mothersFirstName.name]: Yup.string().required(`${mothersFirstName.requiredErrorMsg}`),
    [mothersLastName.name]: Yup.string().required(`${mothersLastName.requiredErrorMsg}`)
  }),
  Yup.object().shape({
    [fathersId.name]: Yup.string().required(`${fathersId.requiredErrorMsg}`).test(
        'len',
        `${fathersId.legthErrorMsg}`,
        val => val && val.length === 11
      ),
    [fathersFirstName.name]: Yup.string().required(`${fathersFirstName.requiredErrorMsg}`),
    [fathersLastName.name]: Yup.string().required(`${fathersLastName.requiredErrorMsg}`)
  }),
  Yup.object().shape({
    [mobileNumber.name]: Yup.string().required(`${mobileNumber.requiredErrorMsg}`).test(
        'len',
        `${mobileNumber.notValidErrorMsg}`,
        val => val && val.length === 9
      ),
    [email.name]: Yup.string().email(`${email.notValidErrorMsg}`)
  }) // ,
  // Yup.object().shape({
  //   [nameOnCard.name]: Yup.string().required(`${nameOnCard.requiredErrorMsg}`),
  //   [cardNumber.name]: Yup.string()
  //     .required(`${cardNumber.requiredErrorMsg}`)
  //     .matches(visaRegEx, cardNumber.invalidErrorMsg),
  //   [expiryDate.name]: Yup.string()
  //     .nullable()
  //     .required(`${expiryDate.requiredErrorMsg}`)
  //     .test('expDate', expiryDate.invalidErrorMsg, val => {
  //       if (val) {
  //         const startDate = new Date();
  //         const endDate = new Date(2050, 12, 31);
  //         if (moment(val, moment.ISO_8601).isValid()) {
  //           return moment(val).isBetween(startDate, endDate);
  //         }
  //         return false;
  //       }
  //       return false;
  //     }),
  //   [cvv.name]: Yup.string()
  //     .required(`${cvv.requiredErrorMsg}`)
  //     .test('len', `${cvv.invalidErrorMsg}`, val => val && val.length === 3)
  // })
];








