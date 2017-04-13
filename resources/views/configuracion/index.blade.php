@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/configuracion/') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Configuraci&oacute;n
</a>
@endpush

@push('css')



@endpush

@section('title', 'Configuraci&oacute;n del Sistema')

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



            <form class="form-horizontal" method="post"  action="{{ URL::asset('configuracion') }}" enctype="multipart/form-data">


                {!! csrf_field() !!}



                <div class="form-group{{ $errors->has('tiempo_gracia') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Tiempo de Gracia</label>

                    <div class="col-lg-10"><input type="text" name="tiempo_gracia" placeholder="Ejemplo: 5" class="form-control" value="{{ $data_configuracion->tiempo_gracia }}"> @if ($errors->has('tiempo_gracia'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('tiempo_gracia') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('nombre_sistema') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Nombre del sistema</label>

                    <div class="col-lg-10"><input type="text" name="nombre_sistema" placeholder="Ejemplo: Sistema de Control de Asistenacia" class="form-control" value="{{ $data_configuracion->nombre_sistema }}"> @if ($errors->has('nombre_sistema'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('nombre_sistema') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('nombre_corto_sistema') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Nombre corto del sistema</label>

                    <div class="col-lg-10"><input type="text" name="nombre_corto_sistema" placeholder="Ejemplo: Sistema de Control de Asistenacia" class="form-control" value="{{ $data_configuracion->nombre_corto_sistema }}"> @if ($errors->has('nombre_corto_sistema'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('nombre_corto_sistema') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>



                <div class="form-group"><label class="col-lg-2 control-label">Subir Logo</label>

                    <div class="col-lg-10">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
    <span class="btn btn-default btn-file"><span class="fileinput-new">Seleccionar Logo</span>
    <span class="fileinput-exists"></span><input type="file" name="logo"/></span>
                            <span class="fileinput-filename"></span>
{{--
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
--}}
                        </div>

                            <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                        <p class="text-muted">Se recomienda imagen de 173 x 76px</p>
                    </div>

                </div>




                @if ($data_configuracion->path_logo !='')
                <div class="form-group"><label class="col-lg-2 control-label">Logo Actual</label>

                    <div class="col-lg-10">
                    <img src="{{$data_configuracion->base64_img}}" alt="logo" width="200" style="margin-bottom: 10px">
                    <input type="hidden" name="base64_img" value="{{$data_configuracion->base64_img}}"></input>

                    </div>
                </div>

                    <div class="form-group"><label class="col-lg-2 control-label">Quitar Logo</label>

                        <div class="col-lg-10">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox"    class="onoffswitch-checkbox" id="quitar_logo" name="quitar_logo" value="1"  {{($data_configuracion->path_logo>=1)?"checked=":'null'}}  >
                                    <label class="onoffswitch-label" for="quitar_logo">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>


                @endif




                <div class="form-group"><label class="col-sm-2 control-label">Prioridad</label>

                    <div class="col-sm-10">
                        <select class="form-control" class="form-control m-b" name="prioridad" id="prioridad" >
                                <option value="1"  {{($data_configuracion->prioridad=="1")?"selected":""}}>Nombre (Se utilizara el nombre corto y largo cuando sea necesario)</option>
                                <option value="2"  {{($data_configuracion->prioridad=="2")?"selected":""}}>Logo</option>
                        </select>
                    </div>
                </div>


<input type="hidden" name="logo_old" value="{{$data_configuracion->path_logo}}">


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

