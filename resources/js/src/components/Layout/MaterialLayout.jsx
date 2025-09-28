import React, { useState } from 'react';
import { Paper, CssBaseline, Typography } from '@material-ui/core';
import { ThemeProvider } from '@material-ui/core/styles';


import { theme, useStyle } from './styles';


import MuiAlert from '@material-ui/lab/Alert'

import { useTable } from 'react-table'
import MaUTable from '@material-ui/core/Table'
import TableBody from '@material-ui/core/TableBody'
import TableCell from '@material-ui/core/TableCell'
import TableHead from '@material-ui/core/TableHead'
import TableRow from '@material-ui/core/TableRow'

import SearchBar from "material-ui-search-bar"

const domain = location.protocol + '//' + location.host;

function Table({ columns, data = [] }) {
  // Use the state and functions returned from useTable to build your UI
  const { getTableProps, headerGroups, rows, prepareRow } = useTable({
    columns,
    ...data
  })

  console.log('d', data)

  // Render the UI for your table
  return (
    <MaUTable {...getTableProps()}>
      <TableHead>
        {headerGroups.map(headerGroup => (
          <TableRow {...headerGroup.getHeaderGroupProps()}>
            {headerGroup.headers.map(column => (
              <TableCell {...column.getHeaderProps()}>
                {column.render('Header')}
              </TableCell>
            ))}
          </TableRow>
        ))}
      </TableHead>
      <TableBody>
        {rows.map((row, i) => {
          prepareRow(row)
          return (
            <TableRow {...row.getRowProps()}>
              {row.cells.map(cell => {
                return (
                  <TableCell {...cell.getCellProps()}>
                    {cell.render('Cell')}
                  </TableCell>
                )
              })}
            </TableRow>
          )
        })}
      </TableBody>
    </MaUTable>
  )
}

export default function MaterialLayout(props) {
  const { children } = props;
  const classes = useStyle();

  const [searchedData, setSearchedData] = useState([])
  const columns = React.useMemo(
    () => [
          {
            Header: 'მუნიციპალიტეტი',
            accessor: 'municipality.name',
          },
          {
            Header: 'პირადობის N:',
            accessor: 'kids_personal_number',
          },
          {
            Header: 'სახელი',
            accessor: 'kids_first_name',
          },
          {
            Header: 'გვარი',
            accessor: 'kids_last_name',
          },
          {
            Header: 'ბაღი',
            accessor: 'kindergarten.name',
          }
    ]
  )
  const doSomethingWith = async (value) => {
    let res = [];

    if (value.length > 7) {
      res = await axios.post(`${domain}/api/find-kid`, { kids_personal_number: value });
      setSearchedData(res.data)
      console.log('res',res.data)
    }

    return res;
  }

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <div className={classes.root}>
        <Paper className={classes.paper}>{children}</Paper>
      </div>
      <br/>
      <div className={classes.root}>
        <Paper className={classes.paper}>
           
                <Typography className={classes.titleFont} component="h1" variant="h4" align="center">
                  გადაამოწმეთ რეგისტრაცია პირადი ნომრით
                </Typography>
                <MuiAlert severity="warning" style={{ marginBottom: '1em' }}>
                  <span className={classes.titleFont}>რეგისტრაციის შესამოწმებლად ჩაწერეთ პირადი ნომერი!</span>
                </MuiAlert >
                <SearchBar placeholder="ძებნა" onChange={(newValue) => doSomethingWith(newValue)} />
                <br/>
                { (searchedData && searchedData.length !== 0) ? (<Table columns={columns} data={searchedData} />) : (<div></div>) }
             
        </Paper>
      </div>
    </ThemeProvider>
  );
}
