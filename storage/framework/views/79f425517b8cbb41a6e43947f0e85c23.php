<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <title> <?php echo $__env->yieldContent('title'); ?> | <?php echo e(env('APP_NAME')); ?> | Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="base_url" content="<?php echo e(env('APP_URL')); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php $__env->startSection('body'); ?>

    <body data-sidebar="dark" data-layout-mode="light" <?php echo in_array(request()->route()->getName(), [
        'admin.departments.orders.create',
        'admin.departments.yarn_purchase_order.create',
        'admin.departments.yarn_purchase_order.edit',
        'admin.departments.orders.edit',
    ])
        ? 'class="sidebar-enable vertical-collpsed"'
        : ''; ?>>
    <?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.departments.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.departments.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.departments.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.departments.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\shafi_portal\resources\views/layouts/departments/master.blade.php ENDPATH**/ ?>