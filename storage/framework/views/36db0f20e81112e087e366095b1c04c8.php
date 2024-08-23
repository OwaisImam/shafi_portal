

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Orders'); ?>
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
            <?php echo app('translator')->get('translation.Departments'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?>
            <?php echo e($department->name); ?>

        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            View <?php echo app('translator')->get('translation.YarnProgram'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Job No: </th>
                                        <td><?php echo e($yarnProgram->job->number); ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Name: </th>
                                        <td><?php echo e($yarnProgram->name); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="orders-row">
                        <div id="repeater-container">
                            <table class="table main_table">
                                <thead>
                                    <tr>
                                        <th>Job#</th>
                                        <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="text-center"><?php echo e($order->fabric_construction->name); ?>

                                                (<?php echo e($order->code); ?>)</th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th>Total Kgs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $total_kgs = 0;
                                    ?>
                                    <tr>
                                        <td><?php echo e($yarnProgram->job->number); ?></td>
                                        <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Qty:</th>
                                                            <td><?php echo e($order->order_quantity); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Required Kg:</th>
                                                            <td><?php echo e($yarnProgram->items->where('order_id', $order->id)->first()->required_kgs); ?>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <?php
                                                $total_kgs += $yarnProgram->items
                                                    ->where('order_id', $order->id)
                                                    ->first()->required_kgs;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td><?php echo e($total_kgs); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                                $totalKgs = 0;
                                $totalBags = 0;
                            ?>
                            <?php $__currentLoopData = $yarnProgram->job->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $subTotalKgs = 0;
                                    $subTotalBags = 0;
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h5><?php echo e($order->fabric_construction->name); ?> (<?php echo e($order->code); ?>)
                                        </h5>
                                        <div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Count</th>
                                                        <th>Fiber</th>
                                                        <th>Percentage</th>
                                                        <th>Total Kgs</th>
                                                        <th>Total Bags</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $yarnProgram->items->where('order_id', $order->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($item->count->name); ?></td>
                                                            <td><?php echo e($item->fiber->name); ?></td>
                                                            <td><?php echo e($item->percentage); ?></td>
                                                            <td><?php echo e($item->kgs); ?></td>
                                                            <td><?php echo e($item->bags); ?></td>
                                                        </tr>
                                                        <?php
                                                            $totalKgs += $item->kgs;
                                                            $totalBags += $item->bags;
                                                            $subTotalKgs += $item->kgs;
                                                            $subTotalBags += $item->bags;
                                                        ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total</th>
                                                        <th><?php echo e($subTotalKgs); ?></th>
                                                        <th><?php echo e($subTotalBags); ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <table class="table footer_table">
                                <thead>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="sum_kgs"><?php echo e(number_format($totalKgs, 2)); ?> Kgs</th>
                                        <th id="sum_bags"><?php echo e(number_format($totalBags, 2)); ?> Bags</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end card -->
        </div> <!-- end col -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/inputmask/inputmask.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/inputmask/jquery.inputmask.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/form-mask.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/parsleyjs/parsley.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/form-validation.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/select2/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/spectrum-colorpicker2/spectrum.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/libs/jquery.repeater/jquery.repeater.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/yarn-program-form-repeater.int.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/@chenfengyuan/datepicker/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/js/pages/form-advanced.init.js')); ?>"></script>
    <!-- form advanced init -->
    <script src="<?php echo e(URL::asset('build/libs/toastr/build/toastr.min.js')); ?>"></script>
    <!-- toastr init -->
    <script src="<?php echo e(URL::asset('build/js/pages/toastr.init.js')); ?>"></script>

    <script src="<?php echo e(URL::asset('build/libs/table-edits/build/table-edits.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/table-editable.int.js')); ?>"></script>

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

<?php echo $__env->make('layouts.departments.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\shafi_portal\resources\views/admin/department/yarn_program/view.blade.php ENDPATH**/ ?>