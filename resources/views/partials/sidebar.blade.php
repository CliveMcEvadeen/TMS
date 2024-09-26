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
                    <li class="nav-item"> <a class="nav-link" href="{{ route('property') }}"> Manage Properties </a></li>
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
                    <li class="nav-item"> <a class="nav-link" href="{{ route('tenants') }}"> Manage Tenants </a></li>
                </ul>
            </div>
        </li>

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
                    <li class="nav-item"> <a class="nav-link" href="{{ route('users') }}"> Manage Users </a></li>
                </ul>
            </div>
        </li>

        </li>
        @endrole

        @role('rental-staff')
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="ti-wallet menu-icon"></i>
                <span class="menu-title">Make Payments</span>
            </a>
        </li>


        @endrole

        <li class="nav-item">
            <a class="nav-link" href="{{ route('reports.create') }}">
                <i class="ti-comment menu-icon"></i>
                <span class="menu-title">Chat</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('payments.index') }}">
                <i class="ti-wallet menu-icon"></i>
                <span class="menu-title">Payment History</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#paymentModal">
                <i class="ti-credit-card menu-icon"></i>
                <span class="menu-title">Make a Payment</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('landlord.payments.index') }}">
                <i class="ti-check menu-icon"></i>
                <span class="menu-title">Manage Payments</span>
            </a>
        </li>
    </ul>
    <li class="nav-item {{ $url == 'complaints' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('complaints.create') }}">
                <i class="ti-comment-alt menu-icon"></i>
                <span class="menu-title">Submit a Complaint</span>
            </a>
        </li>

        <li class="nav-item {{ $url == 'complaints' ? 'active' : null }}">
            <a class="nav-link" href="{{ route('complaints.index') }}">
                <i class="ti-comment menu-icon"></i>
                <span class="menu-title">Complaints</span>
            </a>
</nav>
