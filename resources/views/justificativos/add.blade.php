@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/personal/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Crear Justificativo
</a>
@endpush

@push('css')

<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/datapicker/datepicker3.css') }}">

<style>
    .label-danger{
        font-size: 13px;
    }

</style>
@endpush

@section('title', 'Crear Justificativo')

@section('content')





    {{--    @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif--}}


        <div class="ibox float-e-margins animated fadeInDown">

            <div class="ibox-content">
                <form class="form-horizontal" method="post" action="{{ URL::asset('justificativos/add') }}">
                    {!! csrf_field() !!}



                    <div class="form-group{{ $errors->has('id_dispositivo') ? ' has-error' : '' }}">

                    <label class="col-lg-2 control-label">Nombre de Usuario</label>
                     <label class="col-lg-10 control-label " style="text-align: left !important; font-size: 14px"><span style="font-size: 14px">{{$name}}</span></label>



                       
                    </div>




                    <div class="form-group{{ $errors->has('id_dispositivo') ? ' has-error' : '' }}">

                    <label class="col-lg-2 control-label">Tipo de falta</label>
                     <label class="col-lg-10 control-label " style="text-align: left !important; font-size: 14px">
                     <span style="font-size: 14px"><?php 

                switch ($tipo_falta)
                {
                    case 1:
                        echo "<span class='falta falta-primary' >ENTRADA A TIEMPO</span>";
                        
                        break;

                    case 2:
                        echo "<span class='label label-danger' >TARDIA</span>";
                        break;
                    case 3:
                        echo "<span class='label label-danger' >FALTA MARCA ENTRADA</span>";
                        break;
                    case 4:
                        echo "<span class='falta falta-primary' >SALIDA ALMUERZO</span>";
                        break;
                    case 5:
                        echo "<span class='label label-danger' >ENTRADA TARDE DEL ALMUERZO</span>";
                        break;
                    case 6:
                        echo "<span class='falta falta-primary' >SALIDA A TIEMPO</span>";
                        break;
                    case 7:
                        echo "<span class='label label-danger' >SALIDA PREVIA</span>";
                        break;
                    case 8:
                        echo "<span class='label label-danger' >FALTA MARCA SALIDA</span>";
                         break;
                    case 9:


                        echo "<span class='falta'data-toggle='popover' data-placement='auto top' data-content='MARCAJE FUERA DE TODOS LOS RANGOS o no posee horario cargado para esta fecha' data-original-title='' title=''>hora fuera de todos los rangos</span>";
                         break;
                    case 10:
                        echo "<span class='falta falta-primary' >ENTRADA ALMUERZO</span>";
                         break;

                        case 11:
                        echo "<span class='label label-danger' >AUSENCIA</span>";
                         break;

                    default:
                        echo "???";

                }

?></span></label>



                       
                    </div>


                    <div class="form-group{{ $errors->has('id_dispositivo') ? ' has-error' : '' }}">

                    <label class="col-lg-2 control-label">Fecha</label>
                     <label class="col-lg-10 control-label " style="text-align: left !important; font-size: 14px"><span class="label" style="font-size: 14px">{{date('d-m-Y', strtotime($fecha))}}</span></label>


                       
                    </div>


                    <div class="form-group{{ $errors->has('id_dispositivo') ? ' has-error' : '' }}">

                    <label class="col-lg-2 control-label">Hora Marcaje</label>
                     <label class="col-lg-10 control-label " style="text-align: left !important; font-size: 14px"><span class="label" style="font-size: 14px">{{($hora_marcaje=='0') ? "-" : $hora_marcaje}}</span></label>



                       
                    </div>


                    <div class="form-group"><label class="col-sm-2 control-label">Tipos de Justificativos</label>

                        <div class="col-sm-10">
                            <select class="form-control" class="form-control m-b" name="tipojustificativo">
                                @foreach($tiposJustificativos as $tiposJustificativo)
                                    <option value="{{$tiposJustificativo->Classid}}">{{$tiposJustificativo->Classname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>




                    <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Motivo</label>

                        <div class="col-lg-10"><input type="text" name="motivo" placeholder="" class="form-control" value="{{ old('motivo') }}"> @if ($errors->has('motivo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('motivo') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>





                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-5">
                            <button class="btn btn-block btn-primary" type="submit" title="Enviar datos para guardar">Guardar</button>

                        </div>
                    </div>
                    <input type="hidden" name="Userid" value="{{ $id_usuario}}">
                    <input type="hidden" name="fecha" value="{{ $fecha}}">
                    <input type="hidden" name="hora" value="{{ $hora_marcaje}}">
                    <input type="hidden" name="tipo_falta" value="{{ $tipo_falta}}">
                </form>
            </div>
        </div>

@stop



