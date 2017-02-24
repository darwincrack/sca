<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Control de Asistencia| Login</title>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

</head>


<body class="gray-bg">

<div class="passwordBox animated fadeInDown">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">

        <div class="col-md-12">
            <div class="ibox-content">

                <h2 class="font-bold">Recuperar Contraseña</h2>

                <p>
                    Introduce tu direccion de email y te enviaremos instrucciones para recuperar tu contraseña.
                </p>

                <div class="row">

                    <div class="col-lg-12">
                        <form class="m-t" role="form"   method="POST" action="{{ url('/password/email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Dirección de email" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b">Enviar link para restaurar contraseña</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            SCA
        </div>
        <div class="col-md-6 text-right">
            <small>© 2017</small>
        </div>
    </div>
</div>

</body>


</html>
