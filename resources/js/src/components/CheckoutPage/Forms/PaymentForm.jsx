import React from 'react';
import { Grid, Typography } from '@material-ui/core';
import { InputField, DatePickerField } from '../../FormFields';

export default function PaymentForm(props) {

  const { formField } = props;

  const model = {
    id: formField[props.gender + 'Id'],
    firstName: formField[props.gender + 'FirstName'],
    lastName: formField[props.gender + 'LastName']
  }
  return (
    <React.Fragment>
      <Typography className="title-font" variant="h5" gutterBottom>
       ინფორმაცია
      </Typography>
      <Grid container spacing={3}>
        <Grid item xs={12} >
          <InputField isNumber={ true } name={model.id.name} fullWidth label={model.id.label} setFieldValue={props.setFieldValue} />
        </Grid>
        <Grid item xs={12} md={6}>
          <InputField name={model.firstName.name} fullWidth label={model.firstName.label} setFieldValue={props.setFieldValue} />
        </Grid>
        <Grid item xs={12} md={6}>
          <InputField  name={model.lastName.name} fullWidth label={model.lastName.label} setFieldValue={props.setFieldValue} />
        </Grid>
      </Grid>
    </React.Fragment>
  );
}




