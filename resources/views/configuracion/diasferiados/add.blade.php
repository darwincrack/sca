@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('configuracion/diasferiados/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo Feriado
</a>
@endpush

@push('css')

<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/datapicker/datepicker3.css') }}">
@endpush

@section('title', 'Agregar dia Feriado')

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
                <form class="form-horizontal" method="post" action="{{ URL::asset('configuracion/diasferiados/add') }}">
                    {!! csrf_field() !!}


                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Nombre</label>

                        <div class="col-lg-10"><input type="text" name="nombre" placeholder="Ejemplo: Carnaval" class="form-control" value="{{ old('nombre') }}"> @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('dia_feriado') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Dia Feriado</label>

                        <div class="col-lg-10">
                            <div  id="data_1">

                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="dia_feriado" id="dia_feriado" class="form-control" value="{{ old('dia_feriado') }}">
                                    @if ($errors->has('dia_feriado'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('dia_feriado') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('dias') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Duracion en dias</label>

                        <div class="col-lg-10"><input type="number" name="dias" placeholder="Ejemplo: 1" class="form-control" value="{{ old('dias') }}"> @if ($errors->has('dias'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dias') }}</strong>
                                    </span>
                            @endif
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

<script src="{{ URL::asset('assets/js/app.js') }}"></script>

@endpush

