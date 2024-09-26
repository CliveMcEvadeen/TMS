@php
    $settings = App\Models\Settings::get()->keyBy('key');
@endphp

<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5 font-weight-bold" href="{{ url('/') }}"
            style="font-size:18px">{{ $settings['site_name']->value }}</a>
        <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}"><img
                src="{{ $settings['site_logo']->value ? asset('storage/' . $settings['site_logo']->value) : asset('images/logo.png') }}"
                alt="logo" id="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/logo.png') }}"
                        alt="profile" />
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="ti-user text-primary"></i>
                        Profle
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>

@include('payments.payment-modal')
