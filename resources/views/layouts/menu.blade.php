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
















        </ul>

    </div>
</nav>