<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header ">

                <div class=" profile-element">
                    <a href="{{ url('/') }}" alt="Ir a Inicio"> <h1>CSA</h1></a>
                </div>
                <div class="logo-element">
                    SCA
                </div>
            </li>
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

            <li class=" @if (Route::getCurrentRoute()->getPath() == 'personal')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'personal/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="nav-label">Personal</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'personal') ? 'active' : '' }}"><a href="{{ url('personal') }}"><a href="{{ url('/personal') }}">Listar</a></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'personal/add') ? 'active' : '' }}"><a href="{{ url('personal/add') }}"><a href="{{ url('/personal/add') }}">Agregar</a></li>
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
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'grupo/add') ? 'active' : '' }}"><a href="{{ url('grupo/add') }}"><a href="{{ url('/grupo/add') }}">Agregar</a></li>
                </ul>
            </li>



            <li class=" @if (Route::getCurrentRoute()->getPath() == 'subgrupo')
                    active
                 @elseif (Route::getCurrentRoute()->getPath() == 'subgrupo/add')
                    active
                @endif ">
                <a href="index.html"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="nav-label">Sub Grupo</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'subgrupo') ? 'active' : '' }}"><a href="{{ url('subgrupo') }}"><a href="{{ url('/subgrupo') }}">Listar</a></li>
                    <li class="{{ (Route::getCurrentRoute()->getPath() == 'subgrupo/add') ? 'active' : '' }}"><a href="{{ url('subgrupo/add') }}"><a href="{{ url('/subgrupo/add') }}">Agregar</a></li>
                </ul>
            </li>
















        </ul>

    </div>
</nav>