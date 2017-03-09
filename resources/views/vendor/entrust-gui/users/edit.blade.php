@extends(Config::get('entrust-gui.layout'))

@push('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/select2.css') }}">
@endpush


@push('boton_accion')
<a href="{{ route('entrust-gui::users.create') }}" class="btn btn-primary">
    <span class="glyphicon glyphicon-plus"></span>
    Nuevo usuario
</a>
@endpush

@section('title', 'Editar usuario')

@section('heading', 'Edit User')

@section('content')

<div class="col-lg-12">
    <div class="ibox float-e-margins animated fadeInDown">
        <div class="ibox-content">
            <form action="{{ route('entrust-gui::users.update', $user->id) }}" method="post" role="form">
                <input type="hidden" name="_method" value="put">
                @include('entrust-gui::users.partials.form')
                <div class="text-center">
                <button type="submit" id="save" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check"></i></span> Guardar</button>

                <a class="btn btn-labeled btn-default" href="{{ route('entrust-gui::users.index') }}"><span class="btn-label"><i class="fa fa-chevron-left"></i></span> Cancelar</a>
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