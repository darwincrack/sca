<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro</title>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

                   <h1 class="logo-name">

            @if ($data_configuracion->prioridad==1) 
             {{$data_configuracion->nombre_corto_sistema}} 

            @elseif ($data_configuracion->prioridad==2) 
                <img alt="image"  src="{{ URL::asset('assets/img/'.$data_configuracion->path_logo) }}" height="56px">
            @endif

          </h1>

        </div>
            <p>  {{$data_configuracion->nombre_sistema}} </p>
        <h3>CREAR CUENTA </h3>
    
        <form class="m-t" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input id="name" type="text" class="form-control" placeholder="Nombre" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input  id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif

            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" required placeholder="password">
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="form-group">
                <input id="password-confirm" type="password" placeholder="confirmar password" class="form-control" name="password_confirmation" required>

            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">Crear Cuenta</button>

            <p class="text-muted text-center"><small>ya tienes una cuenta?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ url('/login') }}">Login</a>
        </form>

    </div>
</div>

<!-- Mainly scripts -->
<!-- Mainly scripts -->
<script src="{{ URL::asset('assets/js/jquery-2.1.1.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/js/plugins/iCheck/icheck.min.js') }}"></script>


<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
</body>


</html>
