@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Register</h4></div>

        <div class="card-body pt-1">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name:</label><span
                                    class="text-danger">*</span>
                            <input id="firstName" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name"
                                   tabindex="1" placeholder="Enter First Name" value="{{ old('name') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastName">Last Name:</label><span
                                class="text-danger">*</span>
                            <input id="lastName" type="text"
                                   class="form-control{{ $errors->has('lastName') ? ' is-invalid' : '' }}"
                                   name="lastName"
                                   tabindex="1" placeholder="Enter Last Name" value="{{ old('lastName') }}"
                                   autofocus required>
                            <div class="inval   id-feedback">
                                {{ $errors->first('lastName') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document_type">Document Type:</label><span
                                class="text-danger">*</span>
                                <input id="document_type" type="text"
                                   class="form-control{{ $errors->has('document_type') ? ' is-invalid' : '' }}"
                                   name="document_type"
                                   tabindex="1" placeholder="Enter Document Type" value="{{ old('document_type') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('document_type') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">Document:</label><span
                                class="text-danger">*</span>
                            <input id="document" type="text"
                                   class="form-control{{ $errors->has('document') ? ' is-invalid' : '' }}"
                                   name="document"
                                   tabindex="1" placeholder="Enter Document" value="{{ old('document') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('document') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country:</label><span
                                class="text-danger">*</span>
                            <input id="country" type="text"
                                   class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }}"
                                   name="country"
                                   tabindex="1" placeholder="Enter Country" value="{{ old('country') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('country') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address:</label><span
                                class="text-danger">*</span>
                            <input id="address" type="text"
                                   class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                   name="address"
                                   tabindex="1" placeholder="Enter Address" value="{{ old('address') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('address') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label><span
                                class="text-danger">*</span>
                            <input id="phoneNumber" type="text"
                                   class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                                   name="phoneNumber"
                                   tabindex="1" placeholder="Enter Phone Number" value="{{ old('phoneNumber') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('phoneNumber') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email:</label><span
                                    class="text-danger">*</span>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Email address" name="email" tabindex="1"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password
                                :</label><span
                                    class="text-danger">*</span>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                   placeholder="Set account password" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation"
                                   class="control-label">Confirm Password:</label><span
                                    class="text-danger">*</span>
                            <input id="password_confirmation" type="password" placeholder="Confirm account password"
                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                   name="password_confirmation" tabindex="2">
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Already have an account ? <a
                href="{{ route('login') }}">SignIn</a>
    </div>
@endsection
