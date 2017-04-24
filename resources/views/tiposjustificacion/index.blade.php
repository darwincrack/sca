@extends('layouts.template')



    @push('boton_accion')
    <a href="{{ url('/tiposjustificacion/add') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
              Nuevo tipo de Justificaci&oacute;n

    </a>
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'Tipos de Justificaci&oacute;n')

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->




    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped" id="users-table">

            <thead>
            <tr>
                <th>Id</th>
                <th>Nombre </th>
                <th>Action</th>
                <th>Eliminar</th>
            </tr>
            </thead>
        </table>

    </div>
@stop

@push('scripts')


<script src="{{ URL::asset('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },
            ajax: 'tiposjustificacion/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'Classid', name: 'Classid'},
                {data: 'Classname', name: 'Classname'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy', title: 'Reporte de tipos de Justificación', exportOptions: {
                    columns: [ 0, 1]
                }},
                {extend: 'csv', title: 'Reporte de tipos de Justificación', exportOptions: {
                    columns: [ 0, 1]
                }},
                {extend: 'excel', title: 'Reporte de tipos de Justificación', exportOptions: {
                    columns: [ 0, 1]
                }},
                {extend: 'pdf', title: 'Reporte de tipos de Justificación', exportOptions: {
                    columns: [ 0, 1]
                }},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                    }
                }
            ]
        });
    });



$(document).ready(function() {

var table = $('#users-table').DataTable();
 
    $('#users-table tbody').on( 'click', '.delete', function (event) {

        if(confirm("¿Esta seguro que deseas eliminar esto?"))
        {
            event.preventDefault();
            var row = $(this).closest("tr").get(0);
            var id=$(row).find( ".delete" ).data("eliminar");

            $.get("tiposjustificacion/delete/"+id, function(data, status){
                alert("Eliminado con exito!!");
                location.reload();
            });
        }

    });
 
});

</script>

@endpush