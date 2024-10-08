<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | {{ env('APP_NAME') }} | Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ env('APP_URL') }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

@section('body')

    <body data-sidebar="dark" data-layout-mode="light" {!! in_array(request()->route()->getName(), [
        'admin.departments.orders.create',
        'admin.departments.yarn_purchase_order.create',
        'admin.departments.yarn_purchase_order.edit',
        'admin.departments.orders.edit',
    ])
        ? 'class="sidebar-enable vertical-collpsed"'
        : '' !!}>
    @show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.departments.topbar')
        @include('layouts.departments.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.departments.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.departments.vendor-scripts')
</body>

</html>
