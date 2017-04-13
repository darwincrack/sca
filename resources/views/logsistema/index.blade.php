@extends('layouts.template')



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
@endpush

@section('title', 'logs del Sistema')

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
                <th>Modulo </th>
                <th>Accion</th>
                <th>fecha</th>
                <th>usuario</th>
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
            ajax: 'logsistema/data',
            "order": [[ 0, "desc" ]],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'LogSistemaid', name: 'LogSistema.LogSistemaid'},
                {data: 'modulo', name: 'LogSistema.modulo'},
                {data: 'accion', name: 'LogSistema.accion'},
                {data: 'created_at', name: 'LogSistema.created_at'},
                {data: 'name', name: 'users.name'},

            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Reporte de Logs del sistema'},
                {extend: 'pdfHtml5', title: 'Reporte de Logs del sistema',

            @if (Session::get('prioridad')==2) 
                    customize: function ( doc ) {

                    doc.content.splice( 1, 0, {
                        margin: [ 0, -50, 0, 12 ],
                         width: 60,
                        height: 60,
                        alignment: 'left',
                                                image: '{{Session::get('logo_base64')}}'

                       
                    } );
                }
            @endif





            }

            ,

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
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                       
                    } );
                }
            }
        ]
    } );
} )

</script>

@endpush