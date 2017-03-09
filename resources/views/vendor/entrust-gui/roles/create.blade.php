@extends(Config::get('entrust-gui.layout'))

@push('boton_accion')
<a href="{{ route('entrust-gui::roles.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo rol
</a>
@endpush

@section('title', 'Crear rol')


@section('heading', 'Create Role')

@section('content')

<form action="{{ route('entrust-gui::roles.store') }}" method="post" role="form">
    @include('entrust-gui::roles.partials.form')
   <div class="text-center">
    <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>Crear</button>
    <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::roles.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
   </div>
</form>


</div>
</div>
</div>
@endsection
