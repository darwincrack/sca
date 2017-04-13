@extends('layouts.template')



    @push('boton_accion')
    <a href="{{ url('/configuracion/diasferiados/add') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
        Nuevo Feriado
    </a>
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'Dias Feriados')

@section('content')

    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->




    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-center" id="users-table">

        <thead>
        <tr>
            <th>Nombre</th>
            <th>Fecha de Inicio</th>
            <th>Duracion en dias</th>
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
            ajax: 'diasferiados/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'Name', name: 'Name'},
                {data: 'BDate', name: 'Bdate'},
                {data: 'Days', name: 'Days'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy', title: 'Reporte de dias feriados', exportOptions: {
                    columns: [ 0, 1, 2, ]
                }},
                {extend: 'csv', title: 'Reporte de dias feriados', exportOptions: {
                    columns: [ 0, 1, 2, ]
                }},
                {extend: 'excel', title: 'Reporte de dias feriados', exportOptions: {
                    columns: [ 0, 1, 2, ]
                }},
                {extend: 'pdf', title: 'Reporte de dias feriados', exportOptions: {
                    columns: [ 0, 1, 2]
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

</script>

@endpush