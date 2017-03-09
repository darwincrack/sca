
<div class="col-lg-12">
    <div class="ibox float-e-margins animated fadeInDown">
        <div class="ibox-content">

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="input" class="form-control" id="name" placeholder="Nombre" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $model->name }}">
</div>
<div class="form-group">
    <label for="display_name">Nombre para mostrar</label>
    <input type="input" class="form-control" id="display_name" placeholder="Nombre para mostrar" name="display_name" value="{{ (Session::has('errors')) ? old('display_name', '') : $model->display_name }}">
</div>
<div class="form-group">
    <label for="description">Descripcion</label>
    <input type="input" class="form-control" id="description" placeholder="Descripcion" name="description" value="{{ (Session::has('errors')) ? old('description', '') : $model->description }}">
</div>
