@extends('layouts.app')

@section('content')

<div class="content-header">
  <div class="container-fluid">
   <div class="row mb-2">
    <div class="col-sm-6">
     <h1 class="m-0">აღსაზრდელი</h1>
    </div><!-- /.col -->
   </div><!-- /.row -->
  </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <section class="content">
  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">აღსაზრდელების ჩამონათვალი</h3>
      <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px;">          
          <button 
            type="submit" onclick="location.href = '{{ route('kindergarteners.show') }}'" class="btn btn-sm btn-outline-success">
              <i class="fas fa-shield-alt"></i> დამატება
          </button>          
        </div>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-2">
      {!! Form::model($model, ['route' => 'kindergarteners.order']) !!}
      <div style="display: none;" id="checkbox-section"></div>
      <div class="row">

        <div class="col">
                               <div class="form-group">
                            <div class="input-group">
                                <input id="searchable" type="text" class="form-control" placeholder="ძებნა" >
                            </div>
                        </div>
                            </div>
                            <div class="col">
                                <select name="action" id="cars-select" class="custom-select" onchange="updateModels()">
    <option value="" selected>მოქმედება -------></option>
  </select> 
                            </div>
                            <div class="col">
                                <select name="destination" id="models-select" class="custom-select">
    <option value="" selected><------- შედეგი</option>
  </select>
                            </div>

                            <div class="col"><button type="submit" class="btn btn-block btn-outline-primary">შესრულება</button></div>
                          
                        </div>
{!! Form::close() !!}   
      <table class="table table-hover text-nowrap" id="table" >
        
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
 <!-- /.card-footer-->
</div>
<!-- /.card -->
</section>
@endsection

@push('scripts')

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/v/dt/dt-1.10.16/sl-1.2.5/datatables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" charset="utf8" src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/js/dataTables.checkboxes.js"></script>

<script>

var carsSelect = document.getElementById('cars-select');
var modelsSelect = document.getElementById('models-select');

function createCar(name, id) { return { name: name,id: id } }
function createModel(name, id, car) { return { name: name, id: id, car: car } }

function removeOptions(select) {
  while (select.options.length > 1) {                
    select.remove(1);
  }
  select.value = "";
}
function addOptions(select, options) {
  options.forEach(function(option) {
    select.options.add(new Option(option.name, option.id));
  });
}
var cars = [
  createCar('პრიორიტეტის', '1'),
  createCar('სტატუსის შეცვლა', '2')
];

var models = [
  createModel('დასტურის გაუქმება', '0', '1'),
  createModel('დადასტურება', '1', '1'),
  createModel('მომლოდინეთ', '1', '2'),
  createModel('აქტიურით', '2', '2'),
  createModel('გასულით', '4', '2')
];

function updateModels() {
  var selectedCar = carsSelect.value;
  var options = models.filter(function(model) {
    return model.car === selectedCar;
  });
  removeOptions(modelsSelect);
  addOptions(modelsSelect, options);
}

addOptions(carsSelect, cars);


   var app = @json($model);

   const datatable = $('#table').DataTable({
      initComplete : function() {
        $("#example_filter").detach().appendTo('#new-search-area');
      },
      "ordering": true,
      "info": false,
      "autoWidth": false,
      "responsive": true,
      "lengthChange": false,
      fixedColumns: true,
      data: app,
      "order": [[ 0, "desc" ]],
      columnDefs: [
        { targets: 0, visible: false },
        { title: 'მუნიც...', targets: 1 },
        { title: 'ბაღი', targets: 2 },
        { title: 'ასაკი', targets: 3 },
        { title: 'პრიორიტეტი', targets: 4 },
        { title: 'სტატუსი', targets: 5 },
        { title: 'ბავშვის N:', targets: 6 },
        { title: 'დედის N:', targets: 7 },
        { title: 'ბავშვი', targets: 8 },
        { title: 'თარიღი', targets: 9 },
        {
            'targets': 10,
            'checkboxes': {
               'selectRow': true,
               stateSave: false
            }
         },
        { title: 'მოქმედება', targets: 11 }
      ],
      'select': {
         'style': 'multi',
         selector: 'td.dt-checkboxes-cell'
      },
      createdRow: function (row, data, index) {
        if (data.active_status.id == 4) { row.style.backgroundColor = '#ccc';  row.style.color = '#fff'; }
        else if (data.active_status.id == 3) { row.style.backgroundColor = '#19712d'; row.style.color = '#fff'; }
      },
      columns: [
        { data: 'id' },
        { 
          render: function ( data, type, row ) {
            return row.municipality.name ? row.municipality.name : '---'
          }
        },
        { data: 'kindergarten.name' },
        { 
          render: function ( data, type, row ) {
            return row.group_range ? row.group_range.range : '---'
          }
        },
        { 
          render: function ( data, type, row ) {
            return row.priority 
              ? ` <span class="badge badge-${row.priority.has_permission ? 'success' : 'danger' }">${row.priority.has_permission ? 'დადასტურებული <i class="icon fas fa-check"></i>' : 'დაუდასტურებელი' }</span>` 
              : '<span class="badge badge-primary">არ სარგებლობს</span>'
          }
        },
        { 
          render: function ( data, type, row ) {
            return row.active_status.name
          }
        },
        { data: 'kids_personal_number' },
        { data: 'mother_personal_number' },
        { 
          render: function ( data, type, row ) {
            return `${row.kids_first_name} ${row.kids_last_name}`
          }
        },
        { data: 'created_at' },
        { data: 'id', className: 'text-left' },
        {
                data: null,
                className: "dt-center editor-edit",
                render: function ( data, type, row ) {
                  const route = @json(route('kindergarteners.show'));
                  const routeDelate = @json(route('kindergarteners.destroy'));
                  return `${!row.graduate ? `<i style="cursor:pointer; margin-right:17px; color:black;" class="fas fa-edit" 
                    onclick='letsRedirect(event, "${route}", ${row.id})'></i>` : ''}
                          <i style="cursor:pointer; color:black;" class="fas fa-trash" 
                            onclick='nottify(event)' data-href="${routeDelate + '' + row.id}"></i>`
                },
                orderable: false
            }]
   });

  let checkboxDiv = document.querySelector("#checkbox-section");

  function createCheckbox (value) {

    let checkbox = document.createElement('input');

    checkbox.type = "checkbox";
    checkbox.name = "ids[]";
    checkbox.value = value;
    checkbox.checked = true;

    checkboxDiv.appendChild(checkbox);
  }

  window.addEventListener('DOMContentLoaded', (event) => {
    var rows_selected = datatable.column(10).checkboxes.selected();

    setTimeout(function() {
      document.querySelectorAll("tr").forEach((elm) => { elm.classList.remove('selected') })
    Array.from(document.querySelectorAll("input")).map((elm) => { elm.checked = false; })
    }, 300)
    
  });

  $(document).on("change", "input[type='checkbox']", function() {
     var rows_selected = datatable.column(10).checkboxes.selected();
     checkboxDiv.innerHTML = "";

     rows_selected.map(function(value) {
       createCheckbox(value);
     })
  })

  function letsRedirect (event, link, id) {
     event.preventDefault()
    
       document.querySelectorAll("tr").forEach((elm) => { elm.classList.remove('selected') })
       document.querySelectorAll("input").forEach((elm) => { elm.checked = false })
     
     return location.href = link + '/' + id;
   }

   $('#searchable').keyup(function () {
     datatable.search($(this).val()).draw();
   });

   $('.dataTables_filter').css('display', 'none');


</script>
@endpush

@push('styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.10/css/dataTables.checkboxes.css">

<style type="text/css">
  table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected { background-color: #B0BED9; }
</style>
@endpush



