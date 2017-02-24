@extends(Config::get('entrust-gui.layout'))



@push('boton_accion')
<a href="{{ route('entrust-gui::roles.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo rol
</a>
@endpush

@section('title', 'Editar Rol')

@section('heading', 'Edit Role')

@section('content')

    <form action="{{ route('entrust-gui::roles.update', $model->id) }}" method="post" role="form">
        <input type="hidden" name="_method" value="put">
        @include('entrust-gui::roles.partials.form')

        <div class="text-center">
            <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check"></i></span>Guardar</button>
            <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::roles.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span>Cancelar</a>
        </div>
    </form>
            </div>

        </div>

    </div>

@endsection

@push('scripts')


<script src="{{ URL::asset('assets/js/select2.js') }}"></script>

<script>
    (function() {
        $('select').select2();
    })();
</script>

@endpush