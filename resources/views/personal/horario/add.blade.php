@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/personal/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo Personal
</a>
@endpush

@push('css')

<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/clockpicker/clockpicker.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/datapicker/datepicker3.css') }}">

@endpush

@section('title', 'Cargar Horario')

@section('content')





    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div> <!-- end .flash-message -->


        <div class="ibox float-e-margins animated fadeInDown">

            <div class="ibox-content">
                <form class="form-horizontal" method="post" action="{{ URL::asset('horario/add') }}">
                    <input name="id_personal" type="hidden" value="{{$id_persona}}">

                    {!! csrf_field() !!}









    <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped table-center" id="users-table">
        <thead>
        <tr>
            <th>Dias</th>
            <th>Entrada</th>
            <th>Salida</th>
        </tr>
        </thead>
        <tbody>
        <?php $semana = array('domingo','lunes','martes', 'miercoles','jueves','viernes','sabado'); ?>

        @for($i=0;$i<=6;$i++)
        <tr>
                        <td>{{$semana[$i]}}</td>
            <td>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" class="form-control" name="{{$semana[$i].'_entrada'}}">
                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                </div>
            </td>
            <td>
                <div class="input-group clockpicker" data-autoclose="true">
                    <input type="text" class="form-control"   name="{{$semana[$i].'_salida'}}">
                    <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                </div>
            </td>
        </tr>

        @endfor

        </tbody>
    </table>



    </div>


                    @if ($genero=='2')
                    <div class="form-group"><label class="col-lg-2 control-label">Lactancia </label>

                        <div class="col-lg-10">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox"    class="onoffswitch-checkbox" id="activo" name="activo" value="1"   >
                                    <label class="onoffswitch-label" for="activo">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endif

                    <div class="form-group{{ $errors->has('inicio_asignacion') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Inicio Asignacion</label>

                        <div class="col-lg-10">
                            <div  id="data_1">

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="inicio_asignacion" id="inicio_asignacion" class="form-control" value="{{ old('inicio_asignacion') }}">
                                    @if ($errors->has('inicio_asignacion'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('inicio_asignacion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('fin_asignacion') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Fin Asignacion</label>

                        <div class="col-lg-10">
                            <div  id="data_1">

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="fin_asignacion" id="fin_asignacion" class="form-control" value="{{ old('fin_asignacion') }}">
                                    @if ($errors->has('fin_asignacion'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('fin_asignacion') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-4 col-lg-5">
                            <button class="btn btn-block btn-primary" type="submit" title="Enviar datos para guardar">Guardar</button>

                        </div>
                    </div>

                </form>
            </div>
        </div>

@stop

@push('scripts')
{{--rutas js y script--}}
<script src="{{ URL::asset('assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/datapicker/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/clockpicker/clockpicker.js') }}"></script>

<script src="{{ URL::asset('assets/js/app.js') }}"></script>

@endpush

