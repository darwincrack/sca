@extends('layouts.template')



    @push('boton_accion')
  
    @endpush



@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/dataTables/dataTables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/select2/select2.min.css') }}">


<style>
    .table-responsive{
            margin-top: 13px;
    }

        .dataTables_filter {
        display: none;
    }

    div.dataTables_wrapper div.dataTables_info{
        padding-top: 42px;
    }


span.select2.select2-container.select2-container--default.select2-container--below{
    margin-bottom: 18px !important;
}
</style>


@endpush

@section('title', 'Reporte General')

@section('content')



 {!! csrf_field() !!}
    <div class="ibox-content animated fadeInDown">
        <form class="form-horizontal" role="search" >
            <div class="form-group">

                <div class="row">

                </div>



                <div class="row">
                    <div class="col-sm-12">

                        <div class="col-sm-2">
                        <p>Grupos</p>
                            <select class="form-control m-b" name="grupo" id="bagrupo"  title="seleccione grupo">
                             <option value="">Todos</option>
                                @foreach($data_grupo_personals as $data_grupo_personal)
                                    <option value="{{$data_grupo_personal->id}}">{{$data_grupo_personal->nombre}}</option>
                                @endforeach
                            </select>
<br>
<br>
<p>SubGrupos</p>
                            <select class="form-control" class="form-control m-b" name="subgrupo" id="basubgrupo" title="seleccione subgrupo">

                                <option value="" >Todos</option>
                                @foreach($data_subgrupo_personals as $data_subgrupo_personal)
                                    <option value="{{$data_subgrupo_personal->id}}">{{$data_subgrupo_personal->nombre}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-sm-2">
                        <p>Personal</p>
                            <select class="form-control m-b" name="personal" id="personal" title="Seleccione personal">
                                <option value="" selected>Todos</option>
                                 @foreach($data_personals as $data_personal)
                                    <option value="{{$data_personal->Userid}}">{{$data_personal->Userid}} - {{$data_personal->Name}}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-sm-3">
                        <p>Tipo de Actividad</p>
                            <select class="form-control m-b" name="tipo_falta" id="tipo_falta" title="Seleccione Tipo de Actividad" multiple="multiple">
                                <option value="t" selected>todas</option>
                                <option value="1">ENTRADA A TIEMPO</option>
                                <option value="2" >TARDIA</option>
                                <option value="3" >FALTA MARCA ENTRADA</option>
                                <option value="4" >SALIDA ALMUERZO</option>
                                <option value="5" >ENTRADA TARDE DEL ALMUERZO</option>
                                <option value="6" >SALIDA A TIEMPO</option>
                                <option value="7" >SALIDA PREVIA</option>
                                <option value="8" >FALTA MARCA SALIDA</option>
                                <option value="9" >MARCAJE FUERA DE TODOS LOS RANGOS</option>
                                <option value="10" >ENTRADA ALMUERZO</option>
                                <option value="11" >AUSENCIA</option>
                            </select>
                        </div>

                        <div class="col-sm-4">
<p>Fecha de registros</p>

<input class="form-control active" type="text" name="daterange" >

                        </div>



                        <div class="col-sm-1">
                        <p>&nbsp;</p>
                            <button type="button" id="button-buscar" class="btn btn-primary">Buscar</button>
                        </div>
                        <div style="clear: both"></div>


                    </div>

                </div>


            </div>
        </form>

    </div>










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
            <th>Userid</th>
            <th>Nombre</th>

            <th>Fecha</th>
            <th>Hora</th>
            <th>tipo de Actividad</th>
            <th>tiempo penalizado, <strong>formato (H:M:S)</strong></th>
            <th>Grupo</th>
            <th>Subgrupo</th>
            <th>Justificativo</th>
        </tr>
        </thead>
    </table>

    </div>
@stop

@push('scripts')
<script src="{{ URL::asset('assets/js/plugins/moment/moment.min.js') }}"></script>

<script src="{{ URL::asset('assets/js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ URL::asset('assets/js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/app.js') }}"></script>



<script>
$(document).ready(function(){
   $("td:has(.badge-primary)").css("background", "#1ab394");
});



$('input[name="daterange"]').daterangepicker(
{
    locale: {
      format: 'DD-MM-YYYY',
            "separator": " - ",
        "applyLabel": "Aceptar",
        "cancelLabel": "Cancelar",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],

            "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
 "firstDay": 1
    }
});

    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            "order": [],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
            },

            "fnDrawCallback": function (oSettings) {
                $("td:has(.falta-primary)").css("background", "#aafaad");
                $("td:has(.falta-danger)").css("background", "#ff3019");
                $("td:has(.falta-warning)").css("background", "#ff8");
            },
            ajax: 'reportes/data',
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            columns: [
                {data: 'Userid', name: 'Userid'},
                {data: 'Name', name: 'Name'},
                {data: 'fecha', name: 'fecha'},
                {data: 'hora_marcaje', name: 'hora_marcaje'},
                {data: 'tipo_falta', name: 'tipo_falta'},
                {data: 'tiempo_penalizado', name: 'tiempo_penalizado'},
                {data: 'grupo', name: 'grupo'},
                {data: 'subgrupo', name: 'subgrupo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy', title: 'Reporte horario | Usuario: Todos | fecha desde: '+fecha_actual()+', Fecha hasta: '+fecha_actual(),       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'csv', title: 'Reporte horario | Usuario: Todos | fecha desde: '+fecha_actual()+', Fecha hasta: '+fecha_actual(),       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'excel', title: 'Reporte horario | Usuario: Todos | fecha desde: '+fecha_actual()+', Fecha hasta: '+fecha_actual(),       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'pdf', title: 'Reporte horario | Usuario: Todos | fecha desde: '+fecha_actual()+', Fecha hasta: '+fecha_actual(),       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
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











/*boton*/

       $("#button-buscar").click(function() {

var grupo           =   $("#bagrupo").val();
var subgrupo        =   $("#basubgrupo").val();
var personal        =   $("#personal").val();
var actividad       =   $("#tipo_falta").val();
var fecha_inicio    =   $("[name='daterangepicker_start']").val();
var fecha_final     =    $("[name='daterangepicker_end']").val();

if(fecha_inicio==""  && fecha_final=="")
{
    show_fecha_inicio=fecha_actual();
    show_fecha_final= fecha_actual();
}
else
{
    show_fecha_inicio=fecha_inicio;
    show_fecha_final= fecha_final;
}



            $('#users-table').dataTable().fnDestroy();

            $('#users-table').DataTable({
             processing: true,
            serverSide: true,
            "order": [],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Spanish.json"
                },

            "fnDrawCallback": function (oSettings) {
                $("td:has(.falta-primary)").css("background", "#aafaad");
                $("td:has(.falta-danger)").css("background", "#ff3019");
                $("td:has(.falta-warning)").css("background", "#ff8");
            },
                ajax: {
                    'url': 'reportes/generalavanzada',
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    "data" : {
                        'grupo' : grupo,
                        'subgrupo' : subgrupo,
                        'personal' : personal,
                        'actividad' : actividad,
                        'fecha_inicio' : fecha_inicio,
                        fecha_final: fecha_final

                    }
                },

                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                columns: [
                {data: 'Userid', name: 'Userid'},
                {data: 'Name', name: 'Name'},
                {data: 'fecha', name: 'fecha'},
                {data: 'hora_marcaje', name: 'hora_marcaje'},
                {data: 'tipo_falta', name: 'tipo_falta'},
                {data: 'tiempo_penalizado', name: 'tiempo_penalizado'},
                {data: 'grupo', name: 'grupo'},
                {data: 'subgrupo', name: 'subgrupo'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                { extend: 'copy', title: 'Reporte horario | Usuario: '+$("#personal option:selected").text()+' | fecha desde: '+show_fecha_inicio+', Fecha hasta: '+show_fecha_final,       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'csv',  title: 'Reporte horario | Usuario: '+$("#personal option:selected").text()+' | fecha desde: '+show_fecha_inicio+', Fecha hasta: '+show_fecha_final,       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'excel', title: 'Reporte horario | Usuario: '+$("#personal option:selected").text()+' | fecha desde: '+show_fecha_inicio+', Fecha hasta: '+show_fecha_final,       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
                }},
                {extend: 'pdf', title: 'Reporte horario | Usuario: '+$("#personal option:selected").text()+' | fecha desde: '+show_fecha_inicio+', Fecha hasta: '+show_fecha_final,       exportOptions: {
                    columns: [ 0, 1, 2,, 3, 4, 5, 6, 7 ]
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






           $("#personal").select2();
            
            $("#bagrupo").select2();
            
            $("#basubgrupo").select2();
            
            $("#tipo_falta").select2();



            function fecha_actual(){

var f=new Date();
return f.getDate() + "-" + f.getMonth() + "-" + f.getFullYear();

            }

</script>

@endpush