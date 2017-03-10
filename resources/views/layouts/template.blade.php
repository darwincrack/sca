<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistema de Control de Asistencia | @yield('title')</title>

    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}">

    <!-- App css -->
    @stack('css')

</head>

<body class="">

<div id="wrapper">

@include('layouts.menu')

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            @include('layouts.header')
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-8 animated slideInDown">
                <h2>@yield('title')</h2>
            </div>
            <div class="col-sm-4 animated animated slideInDown">
                <div class="title-action">

                @role(['admin','operador'])

                    @stack('boton_accion')
                    
                @endrole    

                </div>
            </div>

        </div>

        <div class="wrapper wrapper-content">
            @yield('content')
        </div>

        @include('layouts.footer')

    </div>
</div>

<!-- Mainly scripts -->
<script src="{{ URL::asset('assets/js/jquery-2.1.1.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ URL::asset('assets/js/inspinia.js') }}"></script>
<script src="{{ URL::asset('assets/js/plugins/pace/pace.min.js') }}"></script>

<!-- App scripts -->
@stack('scripts')




</body>

</html>
