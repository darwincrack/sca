<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen animated fadeInDown">
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
        <h3>   
               {{$data_configuracion->nombre_sistema}} 
        </h3>

        @if ($errors->has('email'))
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>

        </div>
        @endif
        <form class="m-t" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                <input id="email" type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>


            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                <input id="password" placeholder="Password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif

            </div>
            <div class="form-group">

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Recuerdame
                    </label>
                </div>

            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

            <a href="{{ url('/password/reset') }}"><small>Clic si Olvidaste tu Contraseña</small></a>

            <p class="text-muted text-center"><small>No tienes una cuenta?</small></p>

            <a class="btn btn-sm btn-white btn-block" href="{{ url('/register') }}">Crear una cuenta</a>

        </form>

    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ URL::asset('assets/js/jquery-2.1.1.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>


</body>

</html>
