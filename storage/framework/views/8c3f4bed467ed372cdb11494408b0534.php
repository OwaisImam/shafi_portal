<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Form_Elements'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Users
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Permissions
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

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
                                    <td><?php echo e($user->name); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Birthdate :</th>
                                    <td><?php echo e(date('d-m-Y', strtotime($user->dob))); ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail :</th>
                                    <td><?php echo e($user->email); ?></td>
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
                    <form id="addRoleForm" method="post" action="<?php echo e(route('admin.permissions.update', $user->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <?php
                            $groupedPermissions = [];
                            foreach ($permissions as $permission) {
                                $moduleName = explode('-', $permission->name)[0];
                                $groupedPermissions[$moduleName][] = $permission;
                            }
                        ?>
                        <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moduleName => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-md-2 col-form-label">
                                    <?php echo e(str_replace('_', ' ', ucwords($moduleName))); ?></label>
                                <div class="row col-md-10">

                                    <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-2 align-self-center">
                                            <div class="form-check form-checkbox-outline form-check-*">
                                                <input class="form-check-input" type="checkbox" id="<?php echo e($permission->id); ?>"
                                                    <?php echo e(in_array($permission->id, isset($user->role) ? $user->role?->permissions->pluck('id')->toArray() : []) ? 'checked' : ''); ?>

                                                    value="<?php echo e($permission->name); ?>" name="permission[]">
                                                <label class="form-check-label" for="<?php echo e($permission->id); ?>">
                                                    <?php echo e(ucfirst(explode('-', $permission->name)[1])); ?>

                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/owaisimam/PhpStormProjects/shafi_portal/resources/views/admin/permissions/index.blade.php ENDPATH**/ ?>