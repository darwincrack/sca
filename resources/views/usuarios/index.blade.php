@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/estatus/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Home
</a>
@endpush



@section('title', 'titulo')

@section('content')

    @role('admin')
    <p>SOY ADMINISTRADOR</p>
    @endrole

    @role('operador')
    <p>SOY OPERADOR</p>
    @endrole

    @role('usuario')
    <p>SOY USUARIO</p>
    @endrole



  PAGINA INICIAL EN CONSTRUCCION
@stop
