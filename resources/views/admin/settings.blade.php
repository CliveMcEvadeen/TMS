@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="container">
                <h4 class="card-title">{{ $title }}</h4>
                <p class="card-description">
                    Horizontal form layout
                </p>
                <form class="forms-sample" enctype="multipart/form-data" action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="exampleInputUsername1" class="col-sm-3 col-form-label">Business Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="site_sys_name" id="exampleInputUsername1"
                                placeholder="System Name" value="{{ $settings['site_sys_name']->value }}">
                            <input type="hidden" name="site_sys_name_id" value="{{ $settings['site_sys_name']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">System Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="site_name" id="exampleInputUsername2"
                                placeholder="System Name" value="{{ $settings['site_name']->value }}">
                            <input type="hidden" name="site_name_id" value="{{ $settings['site_name']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="site_email" id="exampleInputEmail2"
                                placeholder="Email" value="{{ $settings['site_email']->value }}">
                            <input type="hidden" name="site_email_id" value="{{ $settings['site_email']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="site_contact" id="exampleInputMobile"
                                placeholder="Mobile number" value="{{ $settings['site_contact']->value }}">
                            <input type="hidden" name="site_contact_id" value="{{ $settings['site_contact']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputAddress" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="exampleInputAddress" name="site_address" placeholder="Address">{{ $settings['site_address']->value }}</textarea>
                            <input type="hidden" name="site_address_id" value="{{ $settings['site_address']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputDesc" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="exampleInputDesc" name="site_description" placeholder="Description">{{ $settings['site_description']->value }}</textarea>
                            <input type="hidden" name="site_description_id"
                                value="{{ $settings['site_description']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputsite_logo" class="col-sm-3 col-form-label">Logo</label>
                        <div class="col-sm-9">
                            <img class="border"
                                src="{{ asset($settings['site_logo']->value ? 'storage/' . $settings['site_logo']->value : 'images/logo.png') }}"
                                alt="logo" width="50" />
                            <input type="file" class="form-control" name="site_logo" id="exampleInputsite_logo">
                            <input type="hidden" name="site_logo_id" value="{{ $settings['site_logo']->id }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputsite_logo2" class="col-sm-3 col-form-label">Logo 2</label>
                        <div class="col-sm-9">
                            <img class="border"
                                src="{{ asset($settings['site_logo2']->value ? 'storage/' . $settings['site_logo2']->value : 'images/logo.png') }}"
                                alt="logo2" width="100" />
                            <input type="file" class="form-control" name="site_logo2" id="exampleInputsite_logo2">
                            <input type="hidden" name="site_logo2_id" value="{{ $settings['site_logo2']->id }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Save changes</button>
                </form>
            </div>
        </div>
    </div>
@endsection
