@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/personal/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo Personal
</a>
@endpush

@push('css')

<link rel="stylesheet" href="{{ URL::asset('assets/css/plugins/datapicker/datepicker3.css') }}">
@endpush

@section('title', 'Agregar Personal')

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
                <form class="form-horizontal" method="post" action="{{ URL::asset('personal/add') }}">
                    {!! csrf_field() !!}




                    <div class="form-group{{ $errors->has('Userid') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">ID en dispositivos</label>

                        <div class="col-lg-10"><input type="text" name="Userid" placeholder="Ejemplo: 225" class="form-control" value="{{ old('Userid') }}"> @if ($errors->has('Userid'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('Userid') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('UserCode') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Usuario Nro</label>

                        <div class="col-lg-10"><input type="text" name="UserCode" placeholder="Ejemplo: 225" class="form-control" value="{{ old('UserCode') }}"> @if ($errors->has('UserCode'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('UserCode') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>






                    <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}"><label class="col-lg-2 control-label">Nombre</label>

                        <div class="col-lg-10"><input type="text" name="nombre" placeholder="Ejemplo: Jhon Doe" class="form-control" value="{{ old('nombre') }}"> @if ($errors->has('nombre'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group"><label class="col-sm-2 control-label">Genero</label>

                        <div class="col-sm-10">
                            <select class="form-control" class="form-control m-b" name="genero">
                                @foreach($data_generos as $data_genero)
                                    <option value="{{$data_genero->id}}">{{$data_genero->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group"><label class="col-sm-2 control-label">Departamento</label>

                        <div class="col-sm-10">
                            <select class="form-control" class="form-control m-b" name="departamento">
                                @foreach($data_departamentos as $data_departamento)
                                    <option value="{{$data_departamento->Deptid}}">{{$data_departamento->DeptName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group"><label class="col-sm-2 control-label">Grupo</label>

                        <div class="col-sm-10">
                            <select class="form-control" class="form-control m-b" name="grupo" id="grupo" data-rec="">
                                <option value="">Seleccione</option>

                            @foreach($data_grupo_personals as $data_grupo_personal)
                                    <option value="{{$data_grupo_personal->id}}">{{$data_grupo_personal->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="form-group"><label class="col-sm-2 control-label">Sub Grupo</label>

                        <div class="col-sm-10">
                            <select class="form-control" class="form-control m-b" name="subgrupo" id="subgrupo" >

                                    <option value="" >Seleccione</option>

                            </select>
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

