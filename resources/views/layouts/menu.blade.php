<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header ">

                <div class=" profile-element">
                    <a href="{{ url('/') }}" alt="Ir a Inicio">
                        <h1 class="text-uppercase">

        @if (Session::has('prioridad')) 

            @if (Session::get('prioridad')==1) 
             {{Session::get('nombre_corto_sistema')}} 

            @elseif (Session::get('prioridad')==2) 
                <img alt="image"  src="{{ URL::asset('assets/img/'.Session::get('logo')) }}" height="56px">
            @endif

        @endif
                        </h1>

                    </a>
                </div>
                <div class="logo-element">
                    @if (Session::has('nombre_corto_sistema')) 
                           {{Session::get('nombre_corto_sistema')}} 
                    @endif       

                </div>
            </li>





        @role('admin')
            <li class=" @if (Route::getCurrentRoute()->getPath() == 'usuarios/users')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'usuarios/roles')
                    active

                @endif ">

                <a href="index.html"><i class="fa fa-user" aria-hidden="true"></i> <span class="nav-label">Usuarios</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'usuarios/users') ? 'active' : '' }}"><a href="{{ url('/usuarios/users') }}" >Listar</a></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'usuarios/roles') ? 'active' : '' }}"><a href="{{ url('/usuarios/roles') }}"  >Roles</a></li>

                </ul>
            </li>
        @endrole


            <li class=" @if (Route::getCurrentRoute()->getPath() == 'personal')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'personal/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-users" aria-hidden="true"></i> <span class="nav-label">Personal</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'personal') ? 'active' : '' }}"><a href="{{ url('personal') }}"><a href="{{ url('/personal') }}">Listar</a></li>
                   
            @role(['admin','operador'])

                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'personal/add') ? 'active' : '' }}"><a href="{{ url('personal/add') }}"><a href="{{ url('/personal/add') }}">Agregar</a></li>
            @endrole

                </ul>
            </li>


            <li class=" @if (Route::getCurrentRoute()->getPath() == 'reportes')
                    active
                    @elseif (Route::getCurrentRoute()->getPath() == 'reportes/justificativos')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="nav-label">Reportes</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'reportes') ? 'active' : '' }}"><a href="{{ url('reportes') }}"><a href="{{ url('/reportes') }}">General</a></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'reportes/justificativos') ? 'active' : '' }}"><a href="{{ url('reportes/justificativos') }}"><a href="{{ url('/reportes/justificativos') }}">Justificativos</a></li>

                </ul>
            </li>



            <li class=" @if (Route::getCurrentRoute()->getPath() == 'tiposjustificacion')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'tiposjustificacion/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-user-md" aria-hidden="true"></i> <span class="nav-label">Tipos de Justificaci&oacute;n</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'tiposjustificacion') ? 'active' : '' }}"><a href="{{ url('tiposjustificacion') }}"><a href="{{ url('/tiposjustificacion') }}">Listar</a></li>
            @role(['admin','operador'])        
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'tiposjustificacion/add') ? 'active' : '' }}"><a href="{{ url('tiposjustificacion/add') }}"><a href="{{ url('/tiposjustificacion/add') }}">Agregar</a></li>
            @endrole       
                </ul>
            </li>



            <li class=" @if (Route::getCurrentRoute()->getPath() == 'grupo')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'grupo/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="nav-label">Grupo</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'grupo') ? 'active' : '' }}"><a href="{{ url('grupo') }}"><a href="{{ url('/grupo') }}">Listar</a></li>
            @role(['admin','operador'])        
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'grupo/add') ? 'active' : '' }}"><a href="{{ url('grupo/add') }}"><a href="{{ url('/grupo/add') }}">Agregar</a></li>
            @endrole       
                </ul>
            </li>



            <li class=" @if (Route::getCurrentRoute()->getPath() == 'subgrupo')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'subgrupo/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-university" aria-hidden="true"></i> <span class="nav-label">Sub Grupo</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'subgrupo') ? 'active' : '' }}"><a href="{{ url('subgrupo') }}"><a href="{{ url('/subgrupo') }}">Listar</a></li>

                @role(['admin','operador'])     
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'subgrupo/add') ? 'active' : '' }}"><a href="{{ url('subgrupo/add') }}"><a href="{{ url('/subgrupo/add') }}">Agregar</a></li>
                @endrole    
                </ul>
            </li>





            <li class=" @if (Route::getCurrentRoute()->getPath() == 'configuracion')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'configuracion/general')
                    active
                    @elseif (Route::getCurrentRoute()->getPath() == 'configuracion/diasferiados')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-bars" aria-hidden="true"></i> <span class="nav-label">configuraci&oacute;n</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>

                     @role(['admin'])
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'configuracion') ? 'active' : '' }}"><a href="{{ url('configuracion') }}"><a href="{{ url('/configuracion') }}">General</a></li>
                    @endrole
                    
                 
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'configuracion/diasferiados') ? 'active' : '' }}"><a href="{{ url('configuracion/diasferiados') }}"><a href="{{ url('/configuracion/diasferiados') }}">Dias Feriados</a></li>
                 
                </ul>
            </li>









            @role(['admin'])  
            <li class=" @if (Route::getCurrentRoute()->getPath() == 'logsistema')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <span class="nav-label">Log del sistema</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'logsistema') ? 'active' : '' }}"><a href="{{ url('logsistema') }}"><a href="{{ url('/logsistema') }}">Listar</a></li>

                </ul>
            </li>


            @endrole



        </ul>

    </div>
</nav>