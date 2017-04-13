@extends('layouts.template')



    @push('boton_accion')
    <a href="{{ url('/reportes') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
              Reporte General

    </a>
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'Justificativos')

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
                <th>Nombre</th>
                <th>Fecha de Inicio </th>
                <th>Fecha Final</th>
                <th>Tipo de Justificativo</th>
                <th>Motivo</th>
                <th>Tipo de Falta</th>
                <th>PDF</th>
                <th>Accion</th>
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
            "fnDrawCallback": function (oSettings) {
                $("td:has(.falta-primary)").css("background", "#aafaad");
                $("td:has(.falta-danger)").css("background", "#ff3019");
                $("td:has(.falta-warning)").css("background", "#ff8");
            },
            ajax: 'justificativos/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'Name', name: 'Userinfo.Name'},
                {data: 'BeginTime', name: 'UserLeave.BeginTime'},
                {data: 'EndTime', name: 'UserLeave.EndTime'},
                {data: 'Classname', name: 'LeaveClass.Classname'},
                {data: 'Whys', name: 'UserLeave.Whys'},
                {data: 'tipo_falta', name: 'tipo_falta', searchable: false},
                {data: 'pdf', name: 'pdf', orderable: false, searchable: false},
                {data: 'delete', name: 'delete', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy',  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
                {extend: 'csv', title: 'Reporte de Justificativos',  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
                {extend: 'excel', title: 'Reporte de Justificativos', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
                {extend: 'pdf', title: 'Reporte de Justificativos',  exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
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