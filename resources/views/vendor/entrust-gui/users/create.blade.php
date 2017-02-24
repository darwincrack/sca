@extends(Config::get('entrust-gui.layout'))



@push('boton_accion')
<a href="{{ route('entrust-gui::users.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo Usuario
</a>
@endpush

@section('title', 'Crear Usuario')


@section('heading', 'Create User')

@section('content')
    <div class="col-lg-12">
        <div class="ibox float-e-margins animated fadeInDown">
            <div class="ibox-content">
<form action="{{ route('entrust-gui::users.store') }}" method="post" role="form">
    @include('entrust-gui::users.partials.form')
    <div class="text-center">
    <button type="submit" id="create" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Crear</button>
    <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::users.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
    </div>
</form>
    </div>
    </div>
    </div>
@endsection
