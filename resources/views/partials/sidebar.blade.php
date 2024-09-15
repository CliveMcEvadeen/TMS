@php
    $url = Request::segment(1);
@endphp

<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @role('rental-admin|rental-manager')
           
        <li class="nav-item {{ $url == 'rents' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('rents') }}">
                <i class="ti-layers-alt menu-icon"></i>
                <span class="menu-title">Rentals</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="ti-wallet menu-icon"></i>
                <span class="menu-title">Payments</span>
            </a>
        </li>

        <li class="nav-item {{ $url == 'property' ? 'active' : null }}">
            <a class="nav-link" data-toggle="collapse" href="#property" aria-expanded="false" aria-controls="property">
                <i class="ti-home menu-icon"></i>
                <span class="menu-title">Property</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $url == 'property' ? 'show' : null }}" id="property">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('property') }}"> Manage Properties </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item {{ $url == 'tenants' ? 'active' : null }}">
            <a class="nav-link" data-toggle="collapse" href="#tenants" aria-expanded="false" aria-controls="tenants">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Tenants</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $url == 'tenants' ? 'show' : null }}" id="tenants">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('tenants') }}"> Manage Tenants </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- <li class="nav-item {{ $url == 'owners' ? 'active' : null }}">
            <a class="nav-link" data-toggle="collapse" href="#owners" aria-expanded="false" aria-controls="owners">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Landlords</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $url == 'owners' ? 'show' : null }}" id="owners">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('owners') }}"> Manage Owners </a>
                    </li>
                </ul>
            </div>
        </li> -->

        <!-- <li class="nav-item {{ $url == 'sales' ? 'active' : null }}">
            <a class="nav-link" data-toggle="collapse" href="#sales" aria-expanded="false" aria-controls="sales">
                <i class="ti-money menu-icon"></i>
                <span class="menu-title">Sales</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ $url == 'sales' ? 'show' : null }}" id="sales">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('sales') }}"> Manage Sales </a>
                    </li>
                </ul>
            </div>
        </li> -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('settings') }}">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Settings</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('users') }}"> Manage Users </a>
                    </li>
                </ul>
            </div>
        </li>
        @endrole

        @role('rental-staff')
        

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="ti-wallet menu-icon"></i>
                <span class="menu-title"> Make Payments</span>
            </a>
        </li>

        @endrole

        <li class="nav-item">

                <a class="nav-link" href="{{ route('chatify') }}">

                <i class="ti-comment menu-icon"></i>
                <span class="menu-title">Chat</span>
            </a>
        </li>
    </ul>
</nav>
