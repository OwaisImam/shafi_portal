@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Login')
@endsection

@section('body')

    <body>
    @endsection

    @section('content')
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary-subtle">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Sign in to continue to {{ env('APP_NAME') }}.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ URL::asset('build/images/profile-img.png') }}" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="auth-logo">
                                    <a href="index" class="auth-logo-light">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('build/images/logo-light.svg') }}" alt=""
                                                    class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>

                                    <a href="index" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ URL::asset('build/images/logo.svg') }}" alt=""
                                                    class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" method="post" action="{{ route('client.login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input name="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" id="username" placeholder="Enter Email"
                                                autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">

                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <div
                                                class="input-group auth-pass-inputgroup @error('password') is-invalid @enderror">
                                                <input type="password" name="password"
                                                    class="form-control  @error('password') is-invalid @enderror"
                                                    id="userpassword" value="" placeholder="Enter password"
                                                    aria-label="Password" aria-describedby="password-addon">
                                                <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-check">
                                            <label class="form-check-label" for="remember-check">
                                                Remember me
                                            </label>
                                        </div>

                                        <div class="mt-3 d-grid">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                                In</button>
                                        </div>


                                        <div class="mt-4 text-center">
                                            @if (Route::has('client.password.request'))
                                                <a href="{{ route('client.password.request') }}" class="text-muted"><i
                                                        class="mdi mdi-lock me-1"></i>Forgot
                                                    password?</a>
                                            @endif
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 text-center">

                            <div>
                                <p>©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script> {{ env('APP_NAME') }}. Crafted with <i
                                        class="mdi mdi-heart text-danger"></i>
                                    by Teknik Lab
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- end account-pages -->
    @endsection
