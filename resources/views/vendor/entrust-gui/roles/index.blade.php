@extends(Config::get('entrust-gui.layout'))

@push('boton_accion')
<a href="{{ route('entrust-gui::roles.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo Rol
</a>
@endpush

@section('title', 'Lista de Roles')

@section('heading', 'Roles')

@section('content')

<table class="table table-striped">
    <tr>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Actions</th>
    </tr>
    @foreach($models as $model)
        <tr>
            <td>{{ $model->name }}</td>
            <td>{{ $model->description }}</td>
            <td class="col-xs-3">
                <form action="{{ route('entrust-gui::roles.destroy', $model->id) }}" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <a href="{{ route('entrust-gui::roles.edit', $model->id) }}" class="btn btn-sm btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                    <button type="submit" class="btn btn-sm btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span> Eliminar</button>
 


                </form>
            </td>
        </tr>
    @endforeach
</table>
<div class="text-center">
    {!! $models->render() !!}
</div>
@endsection
