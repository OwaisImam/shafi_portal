<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Purchase_Order'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet"
        type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')); ?>" rel="stylesheet"
        type="text/css">
    <link href="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')); ?>" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="<?php echo e(URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="home-btn d-none d-sm-block">
        <a href="index" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>

    <section class="my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="home-wrapper">
                        <div class="mb-5">
                            <a href="index" class="d-block auth-logo">

                                <img src="<?php echo e(isset($settings->where('type', 'logo_dark')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_dark')->first()->value) : URL::asset('build/images/logo-dark.png')); ?>"
                                    alt="" height="55" class="auth-logo-dark mx-auto">

                                <img src="<?php echo e(isset($settings->where('type', 'logo_light')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_light')->first()->value) : URL::asset('build/images/logo.svg')); ?>"
                                    alt="" height="55" class="auth-logo-light mx-auto">

                            </a>
                        </div>


                        <div class="row justify-content-center">
                            <div class="col-sm-4">
                                <div class="maintenance-img">
                                    <img src="<?php echo e(URL::asset('build/images/maintenance.svg')); ?>" alt=""
                                        class="img-fluid mx-auto d-block">
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-5">Page is Under Maintenance</h3>
                        <p>Please check back in sometime.</p>

                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/pages-maintenance-section.blade.php ENDPATH**/ ?>