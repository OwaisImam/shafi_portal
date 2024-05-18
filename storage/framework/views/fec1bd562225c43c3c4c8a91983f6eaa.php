<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.System_Settings'); ?>
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
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Settings
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            System Settings
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">System Settings</h4>
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="<?php echo e(route('admin.settings.systems.env.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">System Name</label>
                                    <input type="hidden" name="types[]" value="APP_NAME">
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="App Name" value="<?php echo e(env('APP_NAME')); ?>" required name="APP_NAME">
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
                        action="<?php echo e(route('admin.settings.systems.env.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="MAIL_HOST" class="form-label">Mail Host</label>
                                    <input type="hidden" name="types[]" value="MAIL_HOST">
                                    <input type="text" class="form-control" id="MAIL_HOST" placeholder="App Name"
                                        value="<?php echo e(env('MAIL_HOST')); ?>" required name="MAIL_HOST">
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
                                    <label for="MAIL_PORT" class="form-label">Mail Port</label>
                                    <input type="hidden" name="types[]" value="MAIL_PORT">
                                    <input type="text" class="form-control" id="MAIL_PORT" placeholder="App Name"
                                        value="<?php echo e(env('MAIL_PORT')); ?>" required name="MAIL_PORT">
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
                                    <label for="MAIL_USERNAME" class="form-label">Mail Username</label>
                                    <input type="hidden" name="types[]" value="MAIL_USERNAME">
                                    <input type="text" class="form-control" id="MAIL_USERNAME" placeholder="App Name"
                                        value="<?php echo e(env('MAIL_USERNAME')); ?>" required name="MAIL_USERNAME">
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
                                    <label for="MAIL_PASSWORD" class="form-label">Mail Password</label>
                                    <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                                    <input type="password" class="form-control" id="MAIL_PASSWORD"
                                        placeholder="App Name" value="<?php echo e(env('MAIL_PASSWORD')); ?>" required
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
                                    <label for="MAIL_ENCRYPTION" class="form-label">Mail Encryption</label>
                                    <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                                    <input type="text" class="form-control" id="MAIL_ENCRYPTION"
                                        placeholder="App Name" value="<?php echo e(env('MAIL_ENCRYPTION')); ?>" required
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
                                    <label for="MAIL_CC_ADDRESS" class="form-label">Mail CC Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_CC_ADDRESS">
                                    <input type="text" class="form-control" id="MAIL_CC_ADDRESS"
                                        placeholder="App Name" value="<?php echo e(env('MAIL_CC_ADDRESS')); ?>" required
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
                                    <label for="MAIL_TO_ADDRESS" class="form-label">Mail To Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_TO_ADDRESS">
                                    <input type="text" class="form-control" id="MAIL_TO_ADDRESS"
                                        placeholder="App Name" value="<?php echo e(env('MAIL_TO_ADDRESS')); ?>" required
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
                                    <label for="MAIL_FROM_ADDRESS" class="form-label">Mail From Address</label>
                                    <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                                    <input type="text" class="form-control" id="MAIL_FROM_ADDRESS"
                                        placeholder="App Name" value="<?php echo e(env('MAIL_FROM_ADDRESS')); ?>" required
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
                        action="<?php echo e(route('admin.settings.systems.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo_light" class="form-label">Logo Light</label>
                                    <input type="hidden" name="types[]" value="logo_light">
                                    <input type="file" class="form-control" id="logo_light"
                                        value="<?php echo e(old('logo_light')); ?>" name="logo_light">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                    <img class="rounded-circle header-profile-user"
                                        src="<?php echo e(isset($settings->where('type', 'logo_light')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_light')->first()->value) : ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo_dark" class="form-label">Logo Dark</label>
                                    <input type="hidden" name="types[]" value="logo_dark">
                                    <input type="file" class="form-control" id="logo_dark"
                                        value="<?php echo e(old('logo_dark')); ?>" name="logo_dark">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the app name.
                                    </div>
                                    <img class="rounded-circle header-profile-user"
                                        src="<?php echo e(isset($settings->where('type', 'logo_dark')->first()->value) ? App\Helper\Helper::getUploadedFile($settings->where('type', 'logo_dark')->first()->value) : ''); ?>">
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
                    <h4 class="card-title">Organisation Settings</h4>
                    <form class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                        action="<?php echo e(route('admin.settings.systems.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Adddress</label>
                                    <input type="hidden" name="types[]" value="address">
                                    <input type="text" class="form-control" id="address"
                                        value="<?php echo e(isset($settings->where('type', 'address')->first()->value) ? $settings->where('type', 'address')->first()->value : old('address')); ?>"
                                        name="address">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the organisation aaddress.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Numbers</label>
                                    <input type="hidden" name="types[]" value="phone_number">
                                    <input type="text" class="form-control" id="phone_number"
                                        value="<?php echo e(isset($settings->where('type', 'phone_number')->first()->value) ? $settings->where('type', 'phone_number')->first()->value : old('phone_number')); ?>"
                                        name="phone_number">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the phone numbers with (,) seperated.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gst_number" class="form-label">GST Number</label>
                                    <input type="hidden" name="types[]" value="gst_number">
                                    <input type="text" class="form-control" id="gst_number"
                                        value="<?php echo e(isset($settings->where('type', 'gst_number')->first()->value) ? $settings->where('type', 'gst_number')->first()->value : old('gst_number')); ?>"
                                        name="gst_number">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid gst number.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ntn_number" class="form-label">NTN Number</label>
                                    <input type="hidden" name="types[]" value="ntn_number">
                                    <input type="text" class="form-control" id="ntn_number"
                                        value="<?php echo e(isset($settings->where('type', 'ntn_number')->first()->value) ? $settings->where('type', 'ntn_number')->first()->value : old('ntn_number')); ?>"
                                        name="ntn_number">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Enter the valid ntm number
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/parsleyjs/parsley.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
    
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>

    <!-- form advanced init -->
    <script src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>"></script>
    <!-- toastr init -->
    <script src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>"></script>
    <?php if($errors->any()): ?>
        <script>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                toastr["error"]('<?php echo e($error); ?>');
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>
    <?php if(session('success')): ?>
        <script>
            toastr["success"]('<?php echo e(session('success')); ?>');
        </script>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <script>
            toastr["error"]('<?php echo e(session('error')); ?>');
        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/settings/system.blade.php ENDPATH**/ ?>