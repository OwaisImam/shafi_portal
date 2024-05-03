@extends('layouts.master')

@section('title')
    @lang('translation.System_Settings')
@endsection

@section('css')
    <link href="{{ URL::asset('build/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Settings
        @endslot
        @slot('title')
            System Settings
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">System Settings</h4>
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.settings.systems.env.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">System Name</label>
                                    <input type="hidden" name="types[]" value="APP_NAME">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('APP_NAME') }}" required name="APP_NAME">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">SMTP Settings</h4>
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.settings.systems.env.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail Host</label>
                                    <input type="hidden" name="types[]" value="MAIL_HOST">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_HOST') }}" required name="MAIL_HOST">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail Port</label>
                                    <input type="hidden" name="types[]" value="MAIL_PORT">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_PORT') }}" required name="MAIL_PORT">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail Username</label>
                                    <input type="hidden" name="types[]" value="MAIL_USERNAME">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_USERNAME') }}" required
                                        name="MAIL_USERNAME">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail Password</label>
                                    <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                                    <input type="password" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_PASSWORD') }}" required
                                        name="MAIL_PASSWORD">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail Encryption</label>
                                    <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_ENCRYPTION') }}" required
                                        name="MAIL_ENCRYPTION">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail CC Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_CC_ADDRESS">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_CC_ADDRESS') }}" required
                                        name="MAIL_CC_ADDRESS">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail To Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_TO_ADDRESS">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_TO_ADDRESS') }}" required
                                        name="MAIL_TO_ADDRESS">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Mail From Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="{{ env('MAIL_FROM_ADDRESS') }}" required
                                        name="MAIL_FROM_ADDRESS">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Logo Settings</h4>
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="{{ route('admin.settings.systems.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Logo Light</label>
                                    <input type="hidden" name="types[]" value="logo_light">
                                    <input type="file" class="form-control" id="validationCustom01"
                                        value="{{ old('logo_light') }}" name="logo_light">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                    <img class="rounded-circle header-profile-user"
                                        src="{{ isset($settings->where('type', 'logo_light')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_light')->first()->value) : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">Logo Dark</label>
                                    <input type="hidden" name="types[]" value="logo_dark">
                                    <input type="file" class="form-control" id="validationCustom01"
                                        value="{{ old('logo_dark') }}" name="logo_dark">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                    <img class="rounded-circle header-profile-user"
                                        src="{{ isset($settings->where('type', 'logo_dark')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_dark')->first()->value) : '' }}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
    {{-- <script src="{{ URL::asset('build/js/pages/form-advanced.init.js') }}"></script> --}}
    <script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>

    <script src="{{ URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- form advanced init -->
    <script src="{{ URL::asset('build/libs/toastr/build/toastr.min.js') }}"></script>
    <!-- toastr init -->
    <script src="{{ URL::asset('build/js/pages/toastr.init.js') }}"></script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr["error"]('{{ $error }}');
            @endforeach
        </script>
    @endif
    @if (session('success'))
        <script>
            toastr["success"]('{{ session('success') }}');
        </script>
    @endif
    @if (session('error'))
        <script>
            toastr["error"]('{{ session('error') }}');
        </script>
    @endif
@endsection
