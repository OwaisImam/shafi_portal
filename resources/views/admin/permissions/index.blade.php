@extends('layouts.master')

@section('title')
    @lang('translation.Form_Elements')
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('build/libs/toastr/build/toastr.min.css') }}">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Users
        @endslot
        @slot('title')
            Permissions
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Details</h4>

                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name :</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Birthdate :</th>
                                    <td>{{ date('d-m-Y', strtotime($user->dob)) }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Location :</th>
                                    <td>California, United States</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Permissions</h4>
                    <form id="addRoleForm" method="post" action="{{ route('admin.permissions.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        @php
                            $groupedPermissions = [];
                            foreach ($permissions as $permission) {
                                $moduleName = explode('-', $permission->name)[0];
                                $groupedPermissions[$moduleName][] = $permission;
                            }
                        @endphp
                        @foreach ($groupedPermissions as $moduleName => $modulePermissions)
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">
                                    {{ str_replace('_', ' ', ucwords($moduleName)) }}</label>
                                <div class="row col-md-10">

                                    @foreach ($modulePermissions as $permission)
                                        <div class="col-md-2 align-self-center">
                                            <div class="form-check form-checkbox-outline form-check-*">
                                                <input class="form-check-input" type="checkbox" id="{{ $permission->id }}"
                                                    {{ in_array($permission->id, isset($user->role) ? $user->role?->permissions->pluck('id')->toArray() : []) ? 'checked' : '' }}
                                                    value="{{ $permission->name }}" name="permission[]">
                                                <label class="form-check-label" for="{{ $permission->id }}">
                                                    {{ ucfirst(explode('-', $permission->name)[1]) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endforeach
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection


@section('script')
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
