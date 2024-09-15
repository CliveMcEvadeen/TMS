@extends('layouts.app')

@push('header-script')
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
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="border-bottom text-center pb-4">
                        <img src="{{ asset($user->avatar ? 'storage/' . $user->avatar : 'images/logo.png') }}" alt="profile"
                            class="img-fluid img-xl rounded-circle mb-3" width="200" />
                        <div class="mb-3">
                            <h3> {{ ucwords($user->name) }}</h3>
                            <span class="badge badge-primary"> {{ $user->roles[0]->name }}</span>
                        </div>
                        <p class="w-75 mx-auto mb-3">{{ $user->bio }}</p>
                    </div>
                    <div class="py-4">
                        <p class="clearfix">
                            <span class="float-left">
                                Phone
                            </span>
                            <span class="float-right text-muted">
                                {{ $user->contact_no }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left">
                                Mail
                            </span>
                            <span class="float-right text-muted">
                                {{ $user->email }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profile details</h4>
                    <p class="card-description">
                        Update profile form
                    </p>
                    <form class="forms-sample" enctype="multipart/form-data" method="POST"
                        action="{{ route('profile.update', $user->id) }}">
                        @csrf
                        <div class="form-group row">
                            <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" id="exampleInputUsername2"
                                    placeholder="Full name" required value="{{ $user->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" id="exampleInputEmail2"
                                    placeholder="Email" required value="{{ $user->email }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contact_no" id="exampleInputMobile"
                                    placeholder="Mobile number" value="{{ $user->contact_no }}">
                                @error('contact_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Avatar</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="avatar" id="exampleInputMobile"
                                    placeholder="Mobile number">
                                @error('avatar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Change Password</h4>
                    <p class="card-description">
                        You can change your password here
                    </p>
                    <form class="forms-sample" action="{{ route('profile.change_password', $user->id) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Enter New Password" required>
                                <span toggle="#password" class="field-icon toggle-password ti-lock"></span>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Confirm
                                Password</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Confirm Password" required>
                                <span toggle="#password_confirmation" class="field-icon toggle-password ti-lock"></span>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-script')
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
