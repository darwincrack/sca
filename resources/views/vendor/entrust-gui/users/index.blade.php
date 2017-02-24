@extends(Config::get('entrust-gui.layout'))

@push('boton_accion')
<a href="{{ route('entrust-gui::users.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo usuario
</a>
@endpush

@section('title', 'Lista de usuarios')


@section('heading', 'Users')

@section('content')

<table class="table table-striped">
  <tr>
     <th>nombre</th>
     <th>Email</th>
     <th>Rol</th>
     <th>Actions</th>
  </tr>

  @foreach($users as $user)

    <tr>
        <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>

        <td>
            <?php if(strtoupper($user->rol->name)=='ADMIN'){
                $color_label='primary';
            }
            elseif(strtoupper($user->rol->name)=='OPERADOR')
            {
                $color_label='success';
            }
            elseif(strtoupper($user->rol->name)=='USUARIO')
            {
                $color_label='warning';
            }
            else
            {
                $color_label='';
            }
           echo  "<label class='label label-".$color_label."'>".$user->rol->name."</label>"; ?>
        </td>
      <td class="col-xs-3">
        <form action="{{ route('entrust-gui::users.destroy', $user->id) }}" method="post">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <a href="{{ route('entrust-gui::users.edit', $user->id) }}" class="btn btn-sm btn-primary editar"><i class="glyphicon glyphicon-edit"></i> Edit</a>

          <button type="submit" class="btn btn-sm btn-danger"><span class="btn-label"><i class="fa fa-trash"></i></span> Eliminar</button>
        </form>
      </td>
    </tr>
  @endforeach
</table>
<div class="text-center">
  {!! $users->render() !!}
</div>
@endsection
