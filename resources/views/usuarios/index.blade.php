@extends('layouts.template')

@push('boton_accion')
<a href="{{ url('/estatus/add') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo usuarios
</a>
@endpush



@section('title', 'titulo')

@section('content')

  prueba
@stop
