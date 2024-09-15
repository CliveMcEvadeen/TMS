@extends('layouts.auth')

@push('header')
    <style>
        .field-icon {
            float: right;
            margin-top: -33px;
            margin-right: 10px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }
    </style>
    {!! htmlScriptTagJsApi() !!}
@endpush

@php
    $settings = App\Models\Settings::get()->keyBy('key');
@endphp

@section('content')
    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo text-center">
                    <img class="img-fluid"
                        src="{{ $settings['site_logo']->value ? asset('storage/' . $settings['site_logo']->value) : asset('images/logo.png') }}"
                        alt="logo" width="50">
                </div>
                <h4 class="text-center">WELCOME TO ReMS</h4>
                <h6 class="font-weight-light text-center">Sign in to continue.</h6>
                @error('email')
                    <div class="alert alert-fill-danger" role="alert">
                        <i class="ti-info-alt"></i>
                        {{ $message }}
                    </div>
                @enderror
                @if ($errors->has('g-recaptcha-response'))
                    <div class="alert alert-fill-danger" role="alert">
                        <i class="ti-info-alt"></i>
                        {{ $errors->first('g-recaptcha-response') }}
                    </div>
                @endif
                <form class="pt-3" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1"
                            placeholder="{{ __('Email Address') }}" value="{{ old('email') }}" required
                            autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-lg" id="password"
                            placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                        <span toggle="#password" class="field-icon toggle-password ti-lock"></span>
                    </div>
                    <!-- Google reCaptcha v2 -->
                    {!! htmlFormSnippet() !!}
                    <div class="mt-3">
                        <button type="submit"
                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input" {{ old('remember') ? 'checked' : '' }}
                                    name="remember">
                                Keep me signed in
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-center mt-16 px-0 items-center justify-between">
                        <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0"
                            style="font-size: 12px">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // show password when toggle
        $("span.toggle-password").click(function() {
            $(this).toggleClass("ti-lock ti-unlock");
            var input = $($(this).attr("toggle"));

            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
